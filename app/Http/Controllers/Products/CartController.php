<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to see your cart.');
        }

        // Get cart items for the authenticated user
        $cartProducts = Cart::where('user_id', Auth::id())->get();

        // Count the number of items in the cart
        $countCart = $cartProducts->count();

        // Check if the cart is empty
        if ($countCart === 0) {
            return view('products.cart', [
                'cartProducts' => $cartProducts,
                'countCart' => $countCart,
                'subtotal' => 0,
                'delivery' => 0,
                'discount' => 0,
                'total' => 0,
                'relatedProducts' => Product::take(4)->orderBy('id', 'desc')->get(),
                'error' => 'Your cart is empty'
            ]);
        }

        // Calculate subtotal
        $subtotal = $cartProducts->sum(fn($item) => $item->price * $item->quantity);

        // Define delivery and discount amounts
        $delivery = 0; // Adjust as needed
        $discount = 3.0; // Adjust as needed

        // Calculate total
        $total = $subtotal + $delivery - $discount;

        // Retrieve related products (if needed)
        $relatedProducts = Product::take(4)->orderBy('id', 'desc')->get();

        // Pass data to view
        return view('products.cart', compact('cartProducts', 'countCart', 'subtotal', 'delivery', 'discount', 'total', 'relatedProducts'));

        // Display number of items in cart
        if ($relatedProducts) {
            return redirect()->route('cart')->with('success', 'You have added '.$countCart.' items to your cart.');
        }
    }


    public function addToCart(Request $request, $id)
    {
        Log::info('Add to cart request received', ['product_id' => $id, 'quantity' => $request->input('quantity')]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to add items to the cart.');
        }

        $product = Product::find($id);
        if (!$product) {
            Log::error('Product not found', ['product_id' => $id]);
            return redirect()->back()->with('error', 'Product not found');
        }

        $quantity = $request->input('quantity', 1);
        if ($quantity <= 0) {
            Log::error('Invalid quantity', ['quantity' => $quantity]);
            return redirect()->back()->with('error', 'Invalid quantity');
        }

        DB::beginTransaction();
        try {
            $cart = Cart::updateOrCreate(
                ['pro_id' => $id, 'user_id' => Auth::user()->id],
                [
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'description' => $product->description,
                    'quantity' => $quantity
                ]
            );

            DB::commit();
            Log::info('Item added to cart', ['cart_item' => $cart]);
            return redirect()->route('cart')->with('success', 'Item added to cart.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding item to cart', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error adding item to cart');
        }
    }


    public function remove($id)
    {
        $userId = Auth::user()->id;
        $removeCart = Cart::where('pro_id', $id)->where('user_id', $userId)->delete();

        if ($removeCart) {
            return redirect()->back()->with('success', 'Item removed from cart.');
        } else {
            return redirect()->back()->with('error', 'Error removing item from cart');
        }
    }

    public function prepareCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to process cart.');
        }

        $request->validate(['price' => 'required|numeric']);
        $value = $request->input('price');
        Session::put('price', $value);

        if ($value > 0) {
            return redirect()->route('cart.checkout')->with('success', 'Cart processed successfully.');
        }

        return redirect()->back()->withErrors(['price' => 'Invalid price.']);
    }

    public function cartCheckout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to checkout.');
        }

        if ($request->isMethod('post')) {
            $price = $request->input('price');
            Session::put('price', $price);
            return redirect()->route('cart.checkout')->with('success', 'Checkout page updated. Proceed to payment.');
        }

        return view('products.checkout');
    }

    public function processCheckout(Request $request)
    {
        // Implement checkout logic here

        return redirect()->route('checkout')->with('success', 'Checkout processed successfully.');
    }

    public function checkout()
    {
        return view('products.checkout');
    }
}
