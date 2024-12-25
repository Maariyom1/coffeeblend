@extends('layouts.app')

@section('title', 'Login || Coffee Blend')

@section('content')

<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_1.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">{{ __('messages.Login') }}</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">{{ __('messages.Home') }}</a></span> <span>{{ __('messages.Login') }}</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <form action="{{ route('login') }}" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
                    @csrf
                    <h3 class="text-white mb-4 billing-heading">{{ __('messages.Login') }}</h3>
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="{{ __('messages.Email Address') }}" autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('messages.Password') }}" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('messages.Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" style="text-decoration: none;" href="{{ route('password.request') }}">
                                        {{ __('messages.Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mt-4">
                                <button name="submit" type="submit" class="btn btn-primary py-3 px-4">
                                    {{ __('messages.Login') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form><!-- END -->
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->

@endsection
