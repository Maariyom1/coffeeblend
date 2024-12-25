@extends('layouts.app')

@section('title', 'Our Gallery || Coffee Blend')

@section('content')

<!-- Slider Section -->
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">{{ __('Gallery') }}</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ url('/home') }}">{{ __('Home') }}</a></span> <span>{{ __('Gallery') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-gallery">
    <div class="container-wrap">
        <div class="row no-gutters">
            @foreach ($ourGallery as $gallery)
            <div class="col-md-3 ftco-animate">
                <a href="{{ route('gallery') }}" class="gallery img d-flex align-items-center" style="background-image: url({{ asset('assets/images/'.$gallery->image.'') }});">
                    <div class="icon mb-4 d-flex align-items-center justify-content-center">
                    <span class="icon-search"></span>
                </div>
                </a>
            </div>
            @endforeach
                {{-- <div class="col-md-3 ftco-animate">
                    <a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url({{ asset('assets/images/gallery-3.jpg') }});">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                        <span class="icon-search"></span>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 ftco-animate">
                    <a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url({{ asset('assets/images/gallery-3.jpg') }});">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                        <span class="icon-search"></span>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 ftco-animate">
                    <a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url({{ asset('assets/images/gallery-4.jpg') }});">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                        <span class="icon-search"></span>
                    </div>
                    </a>
                </div> --}}
    </div>
    </div>
</section>

@endsection
