@extends('layouts.app')

@section('title')
    {{ Auth::user()->name }}'s Booking(s) || Coffee Blend
@endsection

@section('content')

<!-- Slider Section -->
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_2.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">{{ __('Booking') }}</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>{{ __('Booking') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list" style="border-radius: 20px;">
                    <table class="table table-striped table-bordered table-dark mx-auto">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Time') }}</th>
                            <th scope="col">{{ __('Date') }}</th>
                            <th scope="col">{{ __('Phone') }}</th>
                            <th scope="col">{{ __('Message') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col">{{ __('Created At') }}</th>
                            <th scope="col">{{ __('Updated At') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $index => $booking)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $booking->firstname .' '. $booking->lastname }}</td>
                                <td>{{ $booking->time }}</td>
                                <td>{{ $booking->date }}</td>
                                <td>{{ $booking->phone }}</td>
                                <td>{{ $booking->message }}</td>
                                <td>
                                    @if ($booking->status === 1)
                                        {{ __('Avaliable') }}
                                    @elseif ($booking->status === 0)
                                        {{ __('N/A') }}
                                    @endif
                                </td>
                                <td>{{ $booking->created_at }}</td>
                                <td>{{ $booking->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- .col-md-12 -->
            </div>
        </div>
    </div>
</section>
@endsection
