@extends('layouts.app')

@section('title', 'Contact Us || Coffee Blend')

@section('content')

<section class="home-slider owl-carousel">

    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text justify-content-center align-items-center">

          <div class="col-md-7 col-sm-12 text-center ftco-animate">
              <h1 class="mb-3 mt-5 bread">{{ __('Contact Us') }}</h1>
              <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">{{ __('Home') }}</a></span> <span>{{ __('Contact') }}</span></p>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section contact-section">
    <div class="container mt-5">
      <div class="row block-9">
                  <div class="col-md-4 contact-info ftco-animate">
                      <div class="row">
                          <div class="col-md-12 mb-4">
                <h2 class="h4 text-white">Contact Information</h2>
              </div>
              <div class="col-md-12 mb-3">
                <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
              </div>
              <div class="col-md-12 mb-3">
                <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
              </div>
              <div class="col-md-12 mb-3">
                <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
              </div>
              <div class="col-md-12 mb-3">
                <p><span>Website:</span> <a href="#">yoursite.com</a></p>
              </div>
                      </div>
                  </div>
                  <div class="col-md-1"></div>
        <div class="col-md-6 ftco-animate">
          <form method="POST" action="{{ route('contact') }}" class="contact-form">
            @csrf
              <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                    <input name="name" type="text" class="form-control" placeholder="Your Name">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <input name="email" type="text" class="form-control" placeholder="Your Email">
                  </div>
                  </div>
            </div>
            <div class="form-group">
              <input name="subject" type="text" class="form-control" placeholder="Subject">
            </div>
            <div class="form-group">
              <textarea name="message" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
            </div>
            <div class="form-group">
              <input name="submit" type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <div id="map"></div>

@endsection
