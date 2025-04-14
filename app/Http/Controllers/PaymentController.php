<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\SetupIntent;
use Stripe\Customer;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret'));
    }

    public function showPayments()
    {
        $stripe = new \Stripe\StripeClient(config('stripe.secret'));
        $setupIntent = $stripe->setupIntents->create();
        return view('parent.payments', compact('setupIntent'));
    }

    public function showAddCard()
    {
        $stripe = new \Stripe\StripeClient(config('stripe.secret'));
        $setupIntent = $stripe->setupIntents->create();
        return view('parent.add-card', compact('setupIntent'));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Log the start of payment method storage
            Log::info('Starting payment method storage', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            
            // Create or retrieve Stripe customer
            if (!$user->stripe_customer_id) {
                Log::info('Creating new Stripe customer', ['user_id' => $user->id]);
                $customer = Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
                $user->stripe_customer_id = $customer->id;
                $user->save();
                Log::info('Created new Stripe customer', [
                    'user_id' => $user->id,
                    'stripe_customer_id' => $customer->id
                ]);
            } else {
                Log::info('Using existing Stripe customer', [
                    'user_id' => $user->id,
                    'stripe_customer_id' => $user->stripe_customer_id
                ]);
            }

            // Attach the payment method to the customer
            $paymentMethod = $request->payment_method;
            Log::info('Attaching payment method to customer', [
                'user_id' => $user->id,
                'payment_method_id' => $paymentMethod
            ]);
            $customer = Customer::retrieve($user->stripe_customer_id);
            $customer->attachPaymentMethod($paymentMethod);
            Log::info('Successfully attached payment method', [
                'user_id' => $user->id,
                'payment_method_id' => $paymentMethod
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment method saved successfully'
            ]);

        } catch (Exception $e) {
            Log::error('Payment method storage failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? 'not set',
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Failed to save payment method: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createPaymentIntent(Request $request)
    {
        try {
            $user = auth()->user();
            Log::info('Starting payment intent creation', [
                'user_id' => $user->id,
                'amount' => $request->amount
            ]);
            
            // Create or retrieve Stripe customer if not exists
            if (!$user->stripe_customer_id) {
                Log::info('Creating new Stripe customer for payment', ['user_id' => $user->id]);
                $customer = Customer::create([
                    'email' => $user->email,
                    'name' => $user->name
                ]);
                $user->stripe_customer_id = $customer->id;
                $user->save();
                Log::info('Created new Stripe customer for payment', [
                    'user_id' => $user->id,
                    'stripe_customer_id' => $customer->id
                ]);
            }

            // Convert amount to cents (Stripe requires amount in smallest currency unit)
            $amount = $request->amount * 100;
            Log::info('Creating payment intent', [
                'user_id' => $user->id,
                'amount' => $amount,
                'currency' => 'gbp'
            ]);

            // Create a PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'gbp',
                'customer' => $user->stripe_customer_id,
                'payment_method_types' => ['card'],
                'metadata' => [
                    'user_id' => $user->id
                ]
            ]);

            Log::info('Successfully created payment intent', [
                'user_id' => $user->id,
                'payment_intent_id' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);

        } catch (\Exception $e) {
            Log::error('Payment intent creation failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to process payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(),
                $sigHeader,
                config('stripe.webhook.secret')
            );

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    
                    // Save payment record to database
                    $payment = new \App\Models\Payment([
                        'user_id' => $paymentIntent->metadata->user_id,
                        'stripe_payment_id' => $paymentIntent->id,
                        'stripe_payment_method_id' => $paymentIntent->payment_method,
                        'amount' => $paymentIntent->amount / 100, // Convert back to decimal
                        'currency' => $paymentIntent->currency,
                        'status' => 'succeeded',
                        'description' => 'Payment processed successfully'
                    ]);
                    $payment->save();

                    Log::info('Payment succeeded and saved', [
                        'amount' => $paymentIntent->amount,
                        'payment_id' => $paymentIntent->id,
                        'user_id' => $paymentIntent->metadata->user_id
                    ]);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    
                    // Save failed payment record
                    $payment = new \App\Models\Payment([
                        'user_id' => $paymentIntent->metadata->user_id,
                        'stripe_payment_id' => $paymentIntent->id,
                        'stripe_payment_method_id' => $paymentIntent->payment_method,
                        'amount' => $paymentIntent->amount / 100,
                        'currency' => $paymentIntent->currency,
                        'status' => 'failed',
                        'description' => $paymentIntent->last_payment_error ?? 'Payment failed'
                    ]);
                    $payment->save();

                    Log::error('Payment failed', [
                        'payment_id' => $paymentIntent->id,
                        'error' => $paymentIntent->last_payment_error ?? null,
                        'user_id' => $paymentIntent->metadata->user_id
                    ]);
                    break;
            }

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            Log::error('Webhook handling failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}