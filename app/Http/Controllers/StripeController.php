<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function index()
    {
        return view('stripe');
    }

    public function charge(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            "amount" => 1000, // Amount in cents ($10.00)
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Test Payment",
        ]);

        return back()->with('success', 'Payment successful!');
    }
}