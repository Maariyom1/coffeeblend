@extends('layouts.app')

@section('style')
<style>
    #button {
        justify-content: center;
    }
</style>
@endsection

@section('content')
<!-- Slider Section -->
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">{{ __('Reset Email') }}</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>{{ __('Reset Email') }}</span>
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
                    <div class="card-header text-center text-white">{{ __('Reset Email Address') }}</div>
                    <div class="card-body">
                        <form action="{{ route('email.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="row mb-3">
                                <label for="new_email" class="col-md-4 col-form-label text-md-end">{{ __('New Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="new_email" value="{{ $email ?? old('email') }}" required placeholder="{{ __('Input Email') }}" autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $password ?? old('password') }}" required placeholder="{{ __('Input Password') }}" autocomplete="password" autofocus>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" id="button" class="btn btn-primary text-center">{{ __('Update Email') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
