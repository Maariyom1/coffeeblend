@extends('layouts.app')

@section('content')

<!-- Slider Section -->
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Cart</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Cart</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate text-center">
                <!-- Cart Table -->
                <div class="cart-list" style="border-radius: 20px;">
                    <table class="table table-striped table-bordered table-dark mx-auto">
                        <thead style="background-color: #c49b63 !important;"">
                            <tr>
                                <th>&nbsp;#</th>
                                <th>Image</th>
                                <th>Product</th>
                                {{-- <th>{{ __($countCart) }}</th> --}}
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($cartProducts->count() > 0)
                                @foreach ($cartProducts as $cartProduct)
                                    <tr>
                                        <td class="product-remove text-center">
                                            <a href="{{ route('cart.remove', $cartProduct->pro_id) }}">
                                                <span class="icon-close"></span>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <img width="60" height="60" src="{{ asset('assets/images/'.$cartProduct->image) }}" alt="{{ __('Cart Image') }}" class="img-thumbnail">
                                        </td>
                                        <td>
                                            <h5 class="mb-1">{{ $cartProduct->name }}</h5>
                                            <p class="mb-0">{{ $cartProduct->description }}</p>
                                        </td>
                                        <td>${{ $cartProduct->price }}</td>
                                        <td>
                                            <input disabled type="text" name="quantity" class="quantity form-control text-center" value="{{ $cartProduct->quantity }}" min="1" max="100">
                                        </td>
                                        <td>${{ $cartProduct->price * $cartProduct->quantity }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="alert alert-info text-center" style="color: #000; font-weight: 20px;">Your cart is currently empty!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cart Totals -->
        <div class="row justify-content-end">
            <div class="col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                    <h3 class="text-center">{{ __('Cart Totals') }}</h3>
                    <p class="d-flex">
                        <span>{{ __('Subtotal') }}</span>
                        <span>${{ $subtotal }}</span>
                    </p>
                    <p class="d-flex">
                        <span>{{ __('Delivery') }}</span>
                        <span>${{ $delivery }}</span>
                    </p>
                    <p class="d-flex">
                        <span>{{ __('Discount') }}</span>
                        @if ($cartProducts->count() > 0)
                        <span>${{ $discount }}</span>
                        @else
                        <span>${{ 0 }}</span>
                        @endif
                    </p>
                    <hr>
                    <p class="d-flex total-price">
                        <span>{{ __('Total') }}</span>
                        @if ($cartProducts->count() > 0)
                        <span>${{ $total }}</span>
                        @else
                        <span>${{ 0 }}</span>
                        @endif
                    </p>
                </div>
                @if ($cartProducts->count() > 0)
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="price" value="{{ $total }}">
                    <button type="submit" id="checkOutBtn" style="background-color: transparent; color: white !important; width: 100%"><p class="text-white btn btn-primary py-3 px-3">{{ __('Proceed to Checkout') }}</p></button>
                </form>
                @else
                    <p class="text-center alert alert-info">{{ __('You cannot checkout because your cart is empty.') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Related Products Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <span class="subheading">{{ __('Discover') }}</span>
                <h2 class="mb-4">{{ __('Related Products') }}</h2>
                <p>{{ __('Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.') }}</p>
            </div>
        </div>

        <div class="row">
            @foreach ($relatedProducts as $relatedProduct)
                <div class="col-md-3">
                    <div class="menu-entry">
                        <a href="{{ route('product.single', $relatedProduct->id) }}" class="img" style="background-image: url({{ asset('assets/images/'.$relatedProduct->image) }});"></a>
                        <div class="text text-center pt-4">
                            <h3><a href="{{ route('product.single', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></h3>
                            <p>{{ $relatedProduct->description }}</p>
                            <p class="price"><span>${{ $relatedProduct->price }}</span></p>
                            @if ($relatedProduct->in_cart)
                                <!-- Button for products already in cart -->
                                <p><a href="{{ route('product.single', $relatedProduct->id) }}" class="text-white btn btn-primary btn-outline-primary" style="pointer-events: none; opacity: 0.5;">{{ __('Added to Cart') }}</a></p>
                            @else
                                <!-- Button for products not in cart -->
                                <p><a href="{{ route('product.single', $relatedProduct->id) }}" class="text-white btn btn-primary py-3 px-4">{{ __('Add to Cart') }}</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</section>

@endsection

@section('styles')
<style>
    .cart-list {
        border-radius: 20px !important;
    }

    .table-dark {
        background-color: #343a40;
        color: #fff;
    }

    .thead-dark {
        background-color: #c49b63 !important;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .table th {
        color: #000 !important;
    }

    .product-remove a {
        color: #dc3545;
        font-size: 1.5rem;
        text-decoration: none;
    }

    .img-thumbnail {
        border: 1px solid #ddd;
        border-radius: .25rem;
        padding: .2rem;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }
</style>
@endsection

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('checkOutBtn');
        button.addEventListener('mouseover', function() {
            button.style.backgroundColor = '#c49b63'; // Color on hover
            button.style.color = '#fff'; // Text color on hover
        });
        button.addEventListener('mouseout', function() {
            button.style.backgroundColor = 'transparent'; // Color when not hovering
            button.style.color = '#fff'; // Text color when not hovering
        });
    });
</script> --}}

