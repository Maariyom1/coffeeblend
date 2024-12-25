<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Session;
// use App\Models\Product\Order;
// use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{
    public function singleProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return abort(404); // Product not found
        }

        $relatedProducts = Product::where('type', $product->type)
            ->where('id', '!=', $id)
            ->take(4)
            ->orderBy('id', 'desc')
            ->get();

        $checkingInCart = 0; // Default value if not authenticated
        if (Auth::check()) {
            $checkingInCart = Cart::where('pro_id', $id)
                ->where('user_id', Auth::user()->id)
                ->count();
        }

        return view('products.productsingle', compact('product', 'relatedProducts', 'checkingInCart'));
    }


}
