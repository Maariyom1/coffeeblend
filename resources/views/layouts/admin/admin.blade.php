<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Blend Admin Dashboard</title>
    <!-- Include Bootstrap or Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin.css') }}"> <!-- Optional custom CSS -->
    <style>
            .toast { position: fixed; bottom: 20px; right: 20px; min-width: 200px; padding: 10px; border-radius: 5px; background-color: transparent; color: #fff; font-size: 14px; z-index: 9999; display: none; cursor: pointer; /* Change cursor to pointer */ }
            .toast-success { background-color: black; }
            .toast-error { background-color: #dc3545; }
        /* Fade out animation */
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }

        .fade-out {
            animation: fadeOut 1s forwards; /* Animate fade out */
        }

        /* Avatar image style */
        .avatar-img {
            width: 20px; /* Adjust the size as needed */
            height: 20px; /* Adjust the size as needed */
            object-fit: cover; /* Ensure the image covers the area without distortion */
            margin-right: 8px; /* Space between the avatar and the text */
            border-radius: 50%; /* Make the avatar circular */
        }

        /* Optional: Hover effect for the toast */
        .toast:hover {
            opacity: 0.9; /* Slightly decrease opacity on hover */
        }
    </style>

</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-right" id="sidebar-wrapper">
            <div class="sidebar-heading text-white">
                <a href="{{ route('admin.dashboard') }}">
                    CoffeeBlend Admin
                </a>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
                <a href="{{ route('admin.orders') }}" class="list-group-item list-group-item-action bg-dark text-white">Orders</a>
                <a href="{{ route('admin.bookings') }}" class="list-group-item list-group-item-action bg-dark text-white">Bookings</a>
                <a href="{{ route('admin.products') }}" class="list-group-item list-group-item-action bg-dark text-white">Products</a>
                <a href="{{ route('admin.customers') }}" class="list-group-item list-group-item-action bg-dark text-white">Customers</a>
                <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action bg-dark text-white">Settings</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-primary" id="menu-toggle">
                    <!-- Font Awesome Menu Icon -->
                    <i class="fas fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <!-- Display Profile Info with Avatar -->
                        <li class="nav-item active d-flex align-items-center">
                            <a class="nav-link" href="#">
                                <img src="https://via.placeholder.com/40" alt="Admin Avatar" class="avatar-img mr-2">
                                @if(Auth::check())
                                    <span>{{ Auth::user()->name }}</span>
                                @else
                                    <span>Guest</span>
                                @endif
                            </a>
                        </li>

                        <!-- Logout Link -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid mt-4">
                @yield('content')
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <!-- Bootstrap JS and optional custom scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle the menu
        document.getElementById("menu-toggle").addEventListener("click", function() {
            document.getElementById("wrapper").classList.toggle("toggled");
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
