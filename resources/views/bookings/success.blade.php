@extends('layouts.app')

@section('title', 'Successful Booking || Coffee Blend')

@section('content')
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Booking Successful</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Booking Success</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container text-center mt-5">
    <h2 class="text-white">Booking saved!</h2>
    <p>Your booking was a success.</p>
    <a href="{{ url('/home') }}">
        <button style="margin-bottom: 25px" class="btn btn-primary py-3 px-4">{{ __('Back to Homepage') }}</button>
    </a>
</div>
@endsection
