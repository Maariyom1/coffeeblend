<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Check if the user is authenticated using the 'admin' guard
        if (!Auth::guard('admin')->check()) {
            // Redirect to admin login if not authenticated as admin
            return redirect()->route('admin.login');
        }

        // Check if the authenticated admin has the correct role, if applicable
        if (Auth::guard('admin')->user()->role !== 'admin') {
            // Redirect to a different page if the user is not an admin
            return redirect()->route('admin.dashboard')->with('error', 'You do not have admin access.');
        }

        // Allow the request to proceed if authenticated as admin
        return $next($request);
    }
}
