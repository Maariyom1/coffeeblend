<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts\Contact;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\Cart;

class ContactController extends Controller
{
    //
    public function index() {
        return view('contact');
    }

    public function contact(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:500',
            ]);
                // dd($request->all());
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message
            ]);
        } else {
            return redirect()->route('login')->with('error', 'Oops! You need to be logged in to contact us!');
        }

        return redirect()->route('home')->with('success', 'Message sent successfully!');
    }
}
