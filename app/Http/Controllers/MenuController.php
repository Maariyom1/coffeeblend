<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\Product;

class MenuController extends Controller
{
    //
    public function index()
    {
        $products = Product::count();
            // Fetch related products for desserts
        $relatedProductsForDessert = Product::where('type', 'dessert')->take($products)->get();

        // Fetch related products for drinks
        $relatedProductsForDrink = Product::where('type', 'drink')->take($products)->get();

        // Pass both datasets to the view
        return view('menu', compact( 'relatedProductsForDessert', 'relatedProductsForDrink'));
    }

}
