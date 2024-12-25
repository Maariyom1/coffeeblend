<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Services\Service;
use App\Models\Counters\Counter;
use App\Models\Galleries\Gallery;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::select()->orderBy('id', 'desc')->get();

        $productForDrinks = Product::where('type', 'drink')->take(2)->orderBy('id', 'desc')->get();
        $productForDesserts = Product::where('type', 'dessert')->take(2)->orderBy('id', 'desc')->get();


        $service = Service::count();

        $gallery = Gallery::count();

        $ourServices = Service::where('status', 1)
            ->take($service)
            ->orderBy('id', 'desc')
            ->get();

        $count = Service::count();

        $counts = Counter::where('status', 1)
            ->take($count)
            ->get();

        $ourGallery = Gallery::where('status', 1)
            ->take($gallery)
            ->get();

        return view('home', compact( 'products', 'productForDrinks', 'productForDesserts',  'ourServices', 'counts', 'ourGallery'))->with('success', 'Welcome! ' . $user);
    }

    public function default()
    {
       return $this->index();
    }

    public function productOrders(Request $request)
    {
        $products = Product::query()
        ->when($request->status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->when($request->search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('price', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        })
        ->paginate(10); // For pagination

        return $this->index();
    }
}
