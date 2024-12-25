<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Order;

class OrderController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search in the orders table (adjust the model and columns as needed)
        $orders = Order::where('customer_name', 'LIKE', "%$query%")
                    ->orWhere('product', 'LIKE', "%$query%")
                    ->get();

        return response()->json($orders); // Return results as JSON
    }

    public function export()
    {
        $orders = Order::all();

        $csvFileName = 'orders_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $csvFileName);

        // Add CSV headers
        fputcsv($handle, ['Order ID', 'Customer', 'Email', 'Phone', 'Amount', 'Pay Status', 'Date']);

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                $order->firstname,
                $order->email,
                $order->phone,
                $order->total_price,
                $order->payment_status,
                $order->created_at,
            ]);
        }

        fclose($handle);
        exit;
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id); // Fetch the order or throw a 404 error
        return view('admin-panel.order-edit', compact('order')); // Return the edit view with the order data
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class); // Adjust the relationship type as per your database design
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $customerOrders = Order::with('items')->paginate(10);
        $order->update($request->all()); // Update the order with the request data
        return redirect()->route('orders.index', compact('customerOrders'))->with('success', 'Order updated successfully.');
    }


}
