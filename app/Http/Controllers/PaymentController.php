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
            
            // Create or retrieve Stripe customer
            if (!$user->stripe_customer_id) {
                $customer = Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
                $user->stripe_customer_id = $customer->id;
                $user->save();
            }

            // Attach the payment method to the customer
            $paymentMethod = $request->payment_method;
            $customer = Customer::retrieve($user->stripe_customer_id);
            $customer->attachPaymentMethod($paymentMethod);

            return response()->json([
                'success' => true,
                'message' => 'Payment method saved successfully'
            ]);

        } catch (Exception $e) {
            Log::error('Payment method storage failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? 'not set'
            ]);
            return response()->json([
                'error' => 'Failed to save payment method: ' . $e->getMessage()
            ], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('stripe.webhook.secret')
            );

            Log::info('Webhook received', ['type' => $event->type]);

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    Log::info('Payment succeeded', [
                        'amount' => $paymentIntent->amount,
                        'payment_id' => $paymentIntent->id
                    ]);
                    // Here you can add code to update your database
                    break;
                    
                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    Log::error('Payment failed', [
                        'payment_id' => $paymentIntent->id,
                        'error' => $paymentIntent->last_payment_error ?? null
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