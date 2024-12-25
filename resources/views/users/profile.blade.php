@extends('layouts.app')

@section('title')
    @if (Auth::check())
        {{ Auth::user()->name }}'s Profile || Coffee Blend
    @else
        Profile || Coffee Blend
    @endif
@endsection

@section('content')

<!-- Slider Section -->
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">{{ __('Profile') }}</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>{{ __('Profile') }}</span>
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
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Email') }}</th>
                            {{-- <th scope="col">{{ __('Password') }}</th> --}}
                            <th scope="col">{{ __('Change Email') }}</th>
                            <th scope="col">{{ __('Change Password') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col">{{ __('Created At') }}</th>
                            <th scope="col">{{ __('Updated At') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                {{-- <td>{{ $user->password }}</td> --}}
                                <td>
                                    <a href="{{ route('profile-email.reset') }}?user_id=<?php echo $user->id ;?>" class="btn btn-custom  text-center ">{{ __('Change Email') }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('password.request') }}" class="btn btn-primary  text-center ">{{ __('Change Password') }}</a>
                                </td>
                                <td>
                                    @if ($user->status === 1)
                                        {{ __('Available') }}
                                    @elseif ($user->status === 0)
                                        {{ __('N/A') }}
                                    @endif
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
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
