@extends('layouts.app')

@section('content')
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Payment Failed</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Payment Failed</span></p>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <h1>Payment Error</h1>
    <p>There was an issue with your payment. Please try again later or contact support if the problem persists.</p>
    <p><a href="{{ route('cart') }}">Return to Cart</a></p>
</div>
@endsection
