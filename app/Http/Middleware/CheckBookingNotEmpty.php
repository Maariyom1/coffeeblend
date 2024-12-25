<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookings\Booking;

class CheckBookingNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Use Auth facade to get the authenticated user's ID
        $userId = Auth::id();
        $booking = Booking::where('user_id', $userId)->first();

        if (!$booking) {
            return view('home')->with('error', 'No booking found.');
        }

        return $next($request);
    }
}
