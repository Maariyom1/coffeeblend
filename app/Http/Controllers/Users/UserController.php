<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Product\Cart;
use App\Mail\EmailUpdated;
use App\Models\Bookings\Booking;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $users = Auth::user();

        if (!$userId || !$users) {
            return redirect()->route('login')->withErrors(['error' => 'User not authenticated']);
        }

        return view('users.profile', compact('users'))->with('success', 'Page loaded successfully!');
    }

    public function userBookings()
    {
        $userId = Auth::id();
        $bookings = collect();

        if ($userId) {
            $bookings = Booking::whereIn('status', [0, 1]) // Corrected 'status' condition
                ->where('user_id', $userId) // Ensure bookings are tied to the authenticated user
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('users.bookings', compact('bookings'));
    }

    public function showUpdateEmailForm(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'User not authenticated']);
        }

        return view('auth.emails.reset-email', compact('user'));
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'User not authenticated']);
        }

        $data = $request->validate([
            'new_email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if (!Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        // Update the user's email and save
        $user->email = $data['new_email'];
        dd($user instanceof \App\Models\User);
        $user->save();

        try {
            // Send a confirmation email to the new email address
            Mail::send('emails.email-reset-confirmation', ['user' => $user], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Email reset confirmation from ' . config('app.fullname'));
            });

            return view('auth.emails.email_updated', compact('user'))->with('success', 'Email updated successfully. A confirmation email has been sent to your new address.');
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return view('users.profile', compact('user'))->with('error', 'Email updated! However, an error occurred when sending the confirmation email.');
        }
    }
}
