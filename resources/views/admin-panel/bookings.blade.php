@extends('layouts.admin.admin')

@section('content')

<div class="card-header text-black text-left">
    <h4>Customer Bookings</h4>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                All Bookings
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Booking Date</th>
                            <th>Booking Time</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customerBookings as $index => $bookings)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $bookings->id }}</td>
                            <td>{{ $bookings->firstname . ' ' . $bookings->lastname}}</td>
                            <td>
                                <a href="tel:{{ $bookings->phone }}">
                                    {{ $bookings->phone }}
                                </a>
                            </td>
                            <td>
                                {{ $bookings->message }}
                            </td>
                            <td>{{ $bookings->date }}</td>

                            <td>{{ $bookings->time }}</td>

                            {{-- <td>{{ $bookings->payment_status }}</td> --}}

                            <td>{{ $bookings->created_at }}</td>
                        </tr>
                        <!-- Add more orders -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
