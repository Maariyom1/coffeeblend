<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product\Order;
use App\Models\Product\Cart;
use App\Models\Bookings\Booking;

class AdminController extends Controller
{
        public function dashboard()
    {
        $id = Auth::user()->user_id;
        // Count total number of orders
        $countOrders = Order::count();

        // Sum the total revenue where payment_status is 'Completed'
        $totalRevenue = Order::where('payment_status', 'Completed')->sum('total_price'); // Assuming you have 'total_amount' column in your orders table

        // Sum the pending revenue where payment_status is 'Pending'
        $pendingRevenue = Order::where('payment_status', 'Pending')->sum('total_price'); // Assuming you have 'total_amount' column in your orders table

        // Count the number of bookings
        $countBookings = Booking::count();
        // echo $countBookings;

        // Count the number of carts
        $countCarts = Cart::count();

        // Count the number of customer orders (pending orders can be considered as customer orders)
        $pendingOrders = Order::where('payment_status', 'Pending')->count();

        // Retrieve the latest 10 orders, ordered by 'id' in descending order
        $customerOrders = Order::orderBy('id', 'desc')->take(5)->get();

        // Retrieve the latest 10 bookings, ordered by 'id' in descending order
        $customerBookings = Booking::orderBy('id', 'desc')->take(5)->get();


        // Return view with data
        return view('admin-panel.dashboard', compact('countOrders', 'totalRevenue', 'pendingRevenue', 'countBookings', 'countCarts', 'pendingOrders', 'customerOrders', 'customerBookings'))
            ->with('success', 'Welcome to the dashboard');
    }

    public function adminUsers()
    {
        return view('admin.users');
    }

    public function adminSettings()
    {
        return view('admin.settings');
    }

    public function adminProfile()
    {
        return view('admin.profile');
    }

    public function adminShowOrders()
    {
        return view('admin-panel.orders');
    }

    public function adminOrders(Request $request)
    {
        $customerOrders = Order::query()
            ->when($request->status, function ($query, $status) {
                return $query->where('payment_status', $status);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                      ->orWhere('firstname', 'like', "%{$search}%");
                });
            })
            ->paginate(10); // For pagination

        return view('admin-panel.orders', compact('customerOrders'));
    }

    public function editOrders($id)
    {
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Return the view with order data for editing
        return view('admin-panel.order-edit', compact('order'));
    }

    public function updateOrders(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255', // Assuming the form has 'lastname'
            'country' => 'required|string|max:255', // Assuming the form has 'country'
            'state' => 'required|string|max:255', // Assuming the form has 'state'
            'street_address' => 'required|string|max:255', // Assuming the form has 'streetaddress'
            'street_address2' => 'nullable|string|max:255', // Optional
            'towncity' => 'required|string|max:255', // Assuming the form has 'towncity'
            'postcodezip' => 'required|string|max:255', // Assuming the form has 'postcodezip'
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string|max:255', // Assuming the form has 'payment_method'
            // Add payment_status if it's part of the form and the model
        ]);

        // Find the order by ID
        $order = Order::findOrFail($id);

        // Update order details based on form data
        $order->firstname = $request->firstname;
        $order->lastname = $request->lastname;
        $order->country = $request->country;
        $order->state = $request->state;
        $order->street_address = $request->street_address;
        $order->street_address2 = $request->street_address2;
        $order->towncity = $request->towncity;
        $order->postcodezip = $request->postcodezip;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->total_price = $request->total_price;
        $order->payment_method = $request->payment_method;

        // If you want to handle 'payment_status' in the model, you can add it to the model's $fillable array
        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        // Save the changes
        $order->save();

        // Redirect back with a success message
        return redirect()->route('admin.orders')->with('success', 'Order updated successfully');
    }

    public function exportOrders()
    {
        ;
    }

    public function adminBookings()
    {
        // Retrieve the latest 10 bookings, ordered by 'id' in descending order
        $customerBookings = Booking::orderBy('id', 'desc')->get();

        return view('admin-panel.bookings', compact('customerBookings'))->with('success', 'Booking page updated!');
    }

    public function adminProducts()
    {
        return view('admin.products');
    }

    public function adminShowProductUpdateForm($id)
    {
        return view('admin.products.update', compact('id'));
    }

    public function adminProductUpdate(Request $request)
    {
        /* update logic here */
    }

    public function adminProductsDelete($id)
    {
        /* delete logic here */
    }

    public function adminCustomers()
    {
        return view('admin.customers');
    }
}
