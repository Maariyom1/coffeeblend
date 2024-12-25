<?php

namespace App\Http\Controllers;

use App\Models\Services\Service;
use Illuminate\Http\Request;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    //

    public function index()
    {
        $service = Service::count();

        $ourServices = Service::where('status', 1)
            ->take($service)
            ->orderBy('id', 'desc')
            ->get();

        return view('service', compact( 'ourServices'));
    }
}
