<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Bookings\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
// use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function insertBooking(Request $request)
    {
        Log::info('Checkout form submitted');
        Log::info('Request data: ', $request->all());

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to checkout.');
        }

        try {
            // Validate request data
            $validatedData = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'time' => 'required|string|max:255',
                'date' => 'required|date',
                // 'date' => 'required|date|after:today', // Ensure the date is after today
                'phone' => 'required|string|max:20',
                'message' => 'required|string|max:255'
            ]);

            // Check if the date and time slot is already booked
            $existingBooking = Booking::where('date', $request->date)
                                      ->where('time', $request->time)
                                      ->first();

            if ($existingBooking) {
                Log::warning('Date and time already booked');
                return redirect()->back()->with('error', 'This date and time is already booked. Please choose another slot.');
            }

            // Create a new booking
            $booking = new Booking();
            $booking->firstname = $request->firstname;
            $booking->lastname = $request->lastname;
            $booking->time = $request->time;
            $booking->date = $request->date;
            $booking->phone = $request->phone;
            $booking->message = $request->message;
            $booking->user_id = Auth::id();
            $booking->save();

            // Log success and redirect to success page
            Log::info('Appointment booked successfully');
            if ($booking->date == today()) {
                return redirect()->route('booking.success')->with('success', 'Your appointment has been placed successfully for today!');
            } else {
                return redirect()->route('booking.success')->with('success', 'Your appointment has been placed successfully for <strong>' . $request->date . '</strong>!');
            }

        } catch (\Exception $e) {
            Log::error('Error booking appointment: ' . $e->getMessage(), ['exception' => $e]);

            $messageLength = strlen($request->messsage);

            if ($messageLength > 255) {
                // $bookingMessage = Booking::where($request->message, $request->message);
                return redirect()->back()->with('error', 'The message field must not be greater than 255 characters. There are ' . $messageLength . ' characters. Please try again.');
            } else {
                // Redirect to home with error message
                return redirect()->back()->with('error', 'There was an error booking your appointment. Please try again.');
            }
        }
    }


    public function successfulBooking()
    {
        return view('bookings.success');
    }
}
