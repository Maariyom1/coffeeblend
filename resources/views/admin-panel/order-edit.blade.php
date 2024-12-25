@extends('layouts.admin.admin')

@section('content')

<div class="card-header text-black text-left">
    <h4>Edit Order (ID: {{ $order->id }})</h4>
</div>

<form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
    @method('PUT') <!-- This indicates a PUT request for updating -->
    @csrf

    <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" class="form-control" value="{{ $order->firstname }}" required>
    </div>

    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" class="form-control" value="{{ $order->lastname }}" required>
    </div>

    <div class="form-group">
        <label for="country">Country</label>
        <input type="text" name="country" class="form-control" value="{{ $order->country }}" required>
    </div>

    <div class="form-group">
        <label for="state">State</label>
        <input type="text" name="state" class="form-control" value="{{ $order->state }}" required>
    </div>

    <div class="form-group">
        <label for="address_line1">Street Address</label>
        <input type="text" name="address_line1" class="form-control" value="{{ $order->address_line1 }}" required>
    </div>

    <div class="form-group">
        <label for="address_line2">Address Line 2</label>
        <input type="text" name="address_line2" class="form-control" value="{{ $order->address_line2 }}">
    </div>

    <div class="form-group">
        <label for="towncity">Town/City</label>
        <input type="text" name="towncity" class="form-control" value="{{ $order->towncity }}" required>
    </div>

    <div class="form-group">
        <label for="postcodezip">Postcode/ZIP</label>
        <input type="text" name="postcodezip" class="form-control" value="{{ $order->postcodezip }}" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $order->phone }}" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $order->email }}" required>
    </div>

    <div class="form-group">
        <label for="total_price">Amount</label>
        <input type="number" name="total_price" class="form-control" value="{{ $order->total_price }}" required>
    </div>

    <div class="form-group">
        <label for="payment_method">Payment Method</label>
        <input type="text" name="payment_method" class="form-control" value="{{ $order->payment_method }}" required>
    </div>

    <div class="form-group">
        <label for="payment_status">Payment Status</label>
        <select name="payment_status" class="form-control" required>
            <option value="Pending" {{ $order->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Completed" {{ $order->payment_status == 'Completed' ? 'selected' : '' }}>Completed</option>
            <option value="Cancelled" {{ $order->payment_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Order</button>
</form>

@endsection
