<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- External Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">

    {{-- CSS for Intl-intel-phone --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Flag Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icons/4.1.7/css/flag-icons.min.css">



    <!-- Local CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.timepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        .toast { position: fixed; bottom: 20px; right: 20px; min-width: 200px; padding: 10px; border-radius: 5px; background-color: transparent; color: #fff; font-size: 14px; z-index: 9999; display: none; cursor: pointer; /* Change cursor to pointer */ }
        .toast-success { background-color: transparent; }
        .toast-error { background-color: #dc3545; }
        @keyframes fadeOut { 0% { opacity: 1; } 100% { opacity: 0; } }
        .fade-out { animation: fadeOut 1s forwards; }
        .avatar-img { width: 20px; /* Adjust the size as needed */ height: 20px; /* Adjust the size as needed */ object-fit: cover; /* Ensure the image covers the area without distortion */ margin-right: 8px; /* Space between the avatar and the username */ }
        /* Style for every anchor tag */
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>

        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
              <a class="navbar-brand" href="{{ url('/home') }}">{{ config('app.name') }}<small>{{  env('APP_NAME_SMALL') }}</small></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
              </button>
              <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="{{ route('menu') }}" class="nav-link">Menu</a></li>
                    <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                    <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>

                    @if ($countCart <= 1)
                        <li class="nav-item cart">
                            <a href="{{ route('cart') }}" class="nav-link">
                                <span class="icon icon-shopping_cart" title="{{ __(''.($countCart ?? 0).' item added to cart.') }}"></span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item cart">
                            <a href="{{ route('cart') }}" class="nav-link">
                                <span class="icon icon-shopping_cart" title="{{ __(''.($countCart ?? 0).' items added to cart.') }}"></span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe"></i> {{ __('Language') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="{{ route('language.switch', ['locale' => 'en']) }}"><span class="flag-icon flag-icon-us"></span> English</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.switch', ['locale' => 'fr']) }}"><span class="flag-icon flag-icon-fr"></span> French</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.switch', ['locale' => 'es']) }}"><span class="flag-icon flag-icon-es"></span> Español</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.switch', ['locale' => 'yr']) }}"><span class="flag-icon flag-icon-yr"></span> Yoruba</a></li>
                            <!-- Add more languages here -->
                        </ul>
                    </li>

                    @guest
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                            @if (Route::has('login'))
                                <li class="nav-item"><a href="{{ route('login') }}" class="dropdown-item">User Login</a></li>
                            @endif
                            @if (Route::has('admin.login'))
                                <li class="nav-item"><a href="{{ route('admin.login') }}" class="dropdown-item">Admin Login</a></li>
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="registerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-plus"></i> {{ __('Register') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="registerDropdown">
                            @if (Route::has('register'))
                                <li class="nav-item"><a href="{{ route('register') }}" class="dropdown-item">User Register</a></li>
                            @endif
                            @if (Route::has('admin.register'))
                                <li class="nav-item"><a href="{{ route('admin.register') }}" class="dropdown-item">Admin Register</a></li>
                            @endif
                        </ul>
                    </li>

                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle avatar-img">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user-profile') }}">
                                    {{ __('Profile') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('user-bookings') }}">
                                    {{ __('Bookings') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('admin.login') }}">
                                    {{ __('Admin Login') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest

                    {{-- <!-- Admin Login Button -->
                    @guest
                        @if (Route::has('admin.login'))
                            <li class="nav-item">
                                <a href="{{ route('admin.login') }}" class="nav-link btn btn-primary text-white px-3 rounded-pill shadow-sm" style="border-radius: 30px; border: 2px solid transparent; font-weight: 600;">
                                    <i class="fas fa-user-shield"></i> Admin Login
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a href="{{ route('admin-panel.dashboard') }}" class="nav-link btn btn-primary text-white px-3 rounded-pill shadow-sm" style="border-radius: 30px; border: 2px solid transparent; font-weight: 20;">Admin Dashboard</a>
                        </li>
                    @endguest --}}
                </ul>

              </div>
            </div>
          </nav>
        <!-- END nav -->

        {{-- <main class="py-4">
           @yield('content')
        </main> --}}
        <main>
            @yield('content')
         </main>

    <footer class="ftco-footer ftco-section img">
        <div class="overlay"></div>
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">About Us</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5 mb-md-5">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Recent Blog</h2>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url({{ asset('assets/images/image_1.jpg') }});"></a>
                            <div class="text">
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                                <div class="meta">
                                    <div><a href="#"><span class="fa fa-calendar"></span> Sept 15, 2018</a></div>
                                    <div><a href="#"><span class="fa fa-user"></span> Admin</a></div>
                                    <div><a href="#"><span class="fa fa-comments"></span> 19</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url({{ asset('assets/images/image_2.jpg') }});"></a>
                            <div class="text">
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                                <div class="meta">
                                    <div><a href="#"><span class="fa fa-calendar"></span> Sept 15, 2018</a></div>
                                    <div><a href="#"><span class="fa fa-user"></span> Admin</a></div>
                                    <div><a href="#"><span class="fa fa-comments"></span> 19</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-5 mb-md-5">
                    <div class="ftco-footer-widget mb-4 ml-md-4">
                        <h2 class="ftco-heading-2">Services</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">Cooked</a></li>
                            <li><a href="#" class="py-2 d-block">Deliver</a></li>
                            <li><a href="#" class="py-2 d-block">Quality Foods</a></li>
                            <li><a href="#" class="py-2 d-block">Mixed</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="fa fa-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                                <li><a href="#"><span class="fa fa-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                                <li><a href="#"><span class="fa fa-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | Backend by <a href="https:://wa.me/2347068934844" target="_blank">Bro Code International</a> | Frontend with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            </div>
        </div>
    </footer>



    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
        </svg>
    </div>

  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery-migrate-3.0.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.stellar.min.js') }}"></script>
  <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('assets/js/aos.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.animateNumber.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>
  <script src="{{ asset('assets/js/scrollax.min.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{{ asset('assets/js/google-map.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>
  <script>
        document.addEventListener("DOMContentLoaded", function() {
        // Hide loader after page is fully loaded
        window.addEventListener("load", function() {
            var loader = document.getElementById("ftco-loader");
            if (loader) {
                loader.classList.add("hide");
                setTimeout(function() {
                    loader.style.display = "none";
                }, 500); // Allow time for transition to complete
            }
        });
    });

  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var quantityInput = document.getElementById('quantity');
      var quantityLeftMinus = document.querySelector('.quantity-left-minus');
      var quantityRightPlus = document.querySelector('.quantity-right-plus');

      quantityLeftMinus.addEventListener('click', function() {
        var currentValue = parseInt(quantityInput.value, 10);
        if (currentValue > parseInt(quantityInput.min, 10)) {
          quantityInput.value = currentValue - 1;
        }
      });

      quantityRightPlus.addEventListener('click', function() {
        var currentValue = parseInt(quantityInput.value, 10);
        if (currentValue < parseInt(quantityInput.max, 10)) {
          quantityInput.value = currentValue + 1;
        }
      });
    });
  </script>
<div id="toast-container">
    <div id="toast-success" class="toast toast-success"></div>
    <div id="toast-error" class="toast toast-error"></div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function showToast(message, type) {
            var toast = document.getElementById(`toast-${type}`);
            toast.innerHTML = message;
            toast.style.display = 'block';
            setTimeout(function() {
                toast.classList.add('fade-out');
                setTimeout(function() {
                    toast.style.display = 'none';
                    toast.classList.remove('fade-out');
                }, 1000); // Match the duration of fadeOut animation
            }, 10000); // Display for 10 seconds
            toast.addEventListener('click', function() {
                toast.classList.add('fade-out');
                setTimeout(function() {
                    toast.style.display = 'none';
                    toast.classList.remove('fade-out');
                }, 1000);
            });
        }

        // Check for session messages and show toasts
        @if (session('success'))
            showToast("{!! session('success') !!}", 'success');
        @endif

        @if (session('error'))
            showToast("{!! session('error') !!}", 'error');
        @endif
    });
</script>

</body>
</html>
