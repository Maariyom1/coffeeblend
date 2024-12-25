@extends('layouts.admin.admin')

@section('content')

<style>
    .pagination .page-item .page-link {
        font-size: 0.9em; /* Smaller font */
        padding: 5px 10px; /* Tighter padding */
    }
</style>

<div class="card-header text-black text-left">
    <h4>Customer Orders</h4>
</div>

<!-- Search and Filter Form -->
<form method="GET" action="{{ route('admin.orders.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by Order ID or Customer Name" value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<!-- Summary Statistics -->
<div class="row mb-3">
    <div class="col-md-4">Total Orders: {{ $customerOrders->count() }}</div>
    <div class="col-md-4">Total Revenue: ${{ $customerOrders->sum('total_price') }}</div>
    <div class="col-md-4">Completed Orders: {{ $customerOrders->where('payment_status', 'Completed')->count() }}</div>
</div>

<!-- Export Button -->
<a href="{{ route('admin.orders.export') }}" class="btn btn-success mb-3">Export Orders</a>

<div class="card-body">
    <table class="table">
        <thead>
            <tr>
                <th><a href="{{ route('admin.orders.index', ['sort' => 'id']) }}">Order ID</a></th>
                <th><a href="{{ route('admin.orders.index', ['sort' => 'firstname']) }}">Customer</a></th>
                <th>Email</th>
                <th>Phone</th>
                <th><a href="{{ route('admin.orders.index', ['sort' => 'total_price']) }}">Amount</a></th>
                <th>Pay Status</th>
                <th><a href="{{ route('admin.orders.index', ['sort' => 'created_at']) }}">Date</a></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customerOrders as $orders)
            <tr>
                <td>{{ $orders->id }}</td>
                <td>{{ $orders->firstname }}</td>
                <td>{{ $orders->email }}</td>
                <td>{{ $orders->phone }}</td>
                <td>${{ $orders->total_price }}</td>
                <td class="badge {{ $orders->payment_status == 'Completed' ? 'bg-success' : 'bg-primary' }}">{{ $orders->payment_status }}</td>
                <td>{{ $orders->created_at->format('Y-m-d') }}</td>
                <td>
                    <button class="btn btn-info" data-toggle="modal" data-target="#orderModal{{ $orders->id }}">View</button>
                    <a href="{{ route('admin.orders.edit', $orders->id) }}" class="btn btn-warning">Edit</a>
                </td>
            </tr>

            <!-- Order Details Modal -->
            <div class="modal fade" id="orderModal{{ $orders->id }}" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderModalLabel">Order Details (ID: {{ $orders->id }})</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Items:</strong></p>
                                @if(!is_null($orders->items) && is_array($orders->items) || is_object($orders->items))
                                    <ul>
                                        @foreach ($orders->items as $item)
                                            <li>{{ $item->name }} - ${{ $item->price }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No items available for this order.</p>
                                @endif
                            <p><strong>Shipping Address:</strong> {{ $orders->street_address }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $customerOrders->links() }}
    </div>
</div>

@endsection
