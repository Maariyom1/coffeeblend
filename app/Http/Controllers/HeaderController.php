<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;

class HeaderController extends Controller
{
    //
    public function index() {
        // Get cart items for the authenticated user
        $cartProducts = Cart::where('user_id', Auth::id())->get();

        // Count the number of items in the cart
        $countCart = $cartProducts->count();

        if ($countCart) {
            return view('layouts.app', compact('countCart'));
        }
    }
}
