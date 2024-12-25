<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\Cart;

class CheckCartNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request is for one of the protected checkout routes
        if ($request->is('products/checkout', 'products/payment', 'products/success', 'payment/error')) {
            // Ensure the user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'You need to log in first.');
            }

            // Check if the user's cart has any items with a price greater than 0
            $cartHasItems = Cart::where('user_id', Auth::id())->where('price', '>', 0)->exists();

            // If the cart is empty (no items with a price > 0), redirect to the cart page with an error
            if (!$cartHasItems) {
                return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items to your cart before proceeding.');
            }
        }

        // Proceed to the next middleware or controller action
        return $next($request);
    }
}
