<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;


class StripeController extends Controller
{
    //
    public function processPayment(Request $request)
    {
        $paymentMethodId = $request->payment_method;
        $amount = $request->amount;

        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'payment_method' => $paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function createPaymentIntent(Request $request)
    {
        try {
            // Set your Stripe secret key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create the payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->price * 100, // amount in cents
                'currency' => 'usd',
            ]);

            // Respond with the client secret for further use in JavaScript
            return response()->json([
                'success' => true,
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
