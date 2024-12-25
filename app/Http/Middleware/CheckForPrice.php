<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\Cart;

class CheckCartPrice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the total price from the cart for the authenticated user
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalPrice = $cartItems->sum('price');

        // Check if the total price is greater than zero
        if ($totalPrice <= 0) {
            // Redirect to an error page or home if price is invalid
            return redirect()->route('home')->withErrors('Your cart is empty or the price is invalid.');
        }

        return $next($request);
    }
}
