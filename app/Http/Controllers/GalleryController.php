<?php

namespace App\Http\Controllers;

use App\Models\Galleries\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    //
    public function index() {
        $gallery = Gallery::count();

        $ourGallery = Gallery::where('status', 1)
            ->take($gallery)
            ->orderBy('id', 'desc')
            ->get();

        return view('gallery', compact('ourGallery'));
    }
}
