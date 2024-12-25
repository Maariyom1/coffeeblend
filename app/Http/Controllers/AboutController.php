<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    //
    public function index() {
        // if (!Auth::check()) {
        //     return redirect()->route('login')->with('error', 'You need to be logged in.');
        // }

        return view('about');
    }
}
