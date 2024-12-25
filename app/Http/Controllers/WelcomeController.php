<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    //
    public function index()
    {
        return view('welcome');
    }
}
