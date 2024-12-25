@extends('layouts.app')

@section('title', 'Register || Coffee Blend')

@section('content')
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_2.jpg') }});" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">{{ __('Admin Register') }}</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">{{{ __('Home') }}}</a></span> <span>{{ __('messages.Register') }}</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <form method="POST" action="{{ route('admin.register') }}" class="billing-form ftco-bg-dark p-3 p-md-5">
                    @csrf
                    <h3 class="text-white mb-4 billing-heading">{{ __('Admin Register') }}</h3>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{ __('messages.Username') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.Username') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">{{ __('messages.Email address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.Email Address') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">{{ __('messages.Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('messages.Password') }}" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password-confirm">{{ __('messages.Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('messages.Re-type password') }}" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mt-4">
                                <button name="submit" type="submit" class="btn btn-primary py-3 px-4">{{ __('messages.Register') }}</button>
                            </div>
                        </div>
                    </div>
                </form><!-- END -->
            </div> <!-- .col-md-12 -->
        </div>
    </div>
</section>


@endsection
