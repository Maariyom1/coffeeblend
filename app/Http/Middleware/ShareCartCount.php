<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\Cart; // Make sure you have the correct model for your cart

class ShareCartCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cartProducts = Cart::where('user_id', Auth::id())->get();

        // Calculate the cart count, from the Cart model
        $countCart = $cartProducts->count(); // Modify this to suit your application's logic

        // Share the cart count with all views
        View::share('countCart', $countCart);

        return $next($request);
    }
}
