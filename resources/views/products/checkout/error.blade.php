@extends('layouts.app')

@section('content')
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Checkout Error</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Checkout Error</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container text-center mt-5">
    <h2 class="text-white">There was an error with your checkout! Please try again.</h2>
    <p>Your checkout was not successful.</p>
    {{--  <p>Error message: {{ $errorMessage }}</p>  --}}
    <a href="{{ url('/home') }}">
        <button class="btn btn-primary py-3 px-4">{{ __('Back to Homepage') }}</button>
    </a>
    <a href="{{ route('cart') }}">
        <button class="btn btn-primary py-3 px-4">{{ __('Back to Cart') }}</button>
    </a>
    @if(isset($transactionId))
        <p>Transaction ID: {{ $transactionId }}</p>
    @endif
</div>
@endsection
