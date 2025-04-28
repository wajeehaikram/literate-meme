<?php

namespace App\Http\Controllers;

use App\Models\TutoringSession;

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

    public function showPendingPayments()
    {
        $user = auth()->user();
        $sessions = TutoringSession::where('parent_id', $user->id)
            ->with(['tutor', 'tutorProfile'])
            ->where('end_time', '<', now())
            ->where('is_paid', false)
            ->orderBy('start_time', 'desc')
            ->get();

        return view('parent.payments', ['pendingSessions' => $sessions]);
    }

    public function showCompletedPayments()
    {
        $user = auth()->user();
        $sessions = TutoringSession::where('parent_id', $user->id)
            ->with(['tutor', 'tutorProfile'])
            ->where('end_time', '<', now())
            ->where('is_paid', true)
            ->orderBy('start_time', 'desc')
            ->get();

        return view('parent.completed-payments', ['completedSessions' => $sessions]);
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
                        'description' => 'Payment processed successfully',
                        'booking_id' => $paymentIntent->metadata->booking_id ?? null
                    ]);
                    $payment->save();
                    // Mark the related TutoringSession as paid
                    if (!empty($paymentIntent->metadata->booking_id)) {
                        $session = \App\Models\TutoringSession::find($paymentIntent->metadata->booking_id);
                        if ($session) {
                            $session->is_paid = true;
                            $session->save();
                        }
                    }
                    \Log::info('Payment succeeded and saved', [
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
                        'description' => $paymentIntent->last_payment_error ?? 'Payment failed',
                        'booking_id' => $paymentIntent->metadata->booking_id ?? null
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

    public function payBooking(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $bookingId = $request->input('booking_id', $id);
            $user = auth()->user();
            // Fetch booking details (replace with actual model and logic)
            $booking = \App\Models\TutoringSession::findOrFail($bookingId);
            // Fetch the hourly rate from the related tutor profile
            $hourlyRate = $booking->tutorProfile->hourly_rate ?? 20; // fallback to 20 if not set
            $amount = $hourlyRate;

            \Stripe\Stripe::setApiKey(config('stripe.secret'));
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $booking->subject ?? 'Tutoring Session',
                        ],
                        'unit_amount' => $amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $user->email,
                'metadata' => [
                    'booking_id' => $bookingId,
                    'user_id' => $user->id,
                ],
                'success_url' => route('payment.success'),
                'cancel_url' => url()->previous(),
            ]);
            // Removed misplaced return statement outside of class methods
            return response()->json(['sessionId' => $session->id]);
        }
        return view('parent.pay-booking', ['id' => $id]);
    }
}