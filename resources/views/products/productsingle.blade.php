@extends('layouts.app')

@section('content')

<!-- Slider Section -->
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/'.$product->image) }});" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Product Detail</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Product Detail</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Details Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="{{ asset('assets/images/'.$product->image) }}" class="image-popup">
                    <img src="{{ asset('assets/images/'.$product->image) }}" class="img-fluid" alt="Product Image">
                </a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h3 class="text-white">{{ $product->name }}</h3>
                <p class="price"><span>${{ $product->price }}</span></p>
                <p>{{ $product->description }}</p>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <div class="select-wrap">
                                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                <select name="size" id="size" class="form-control">
                                    <option value="">Small</option>
                                    <option value="">Medium</option>
                                    <option value="">Large</option>
                                    <option value="">Extra Large</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($checkingInCart == 0)
                    <div class="w-100"></div>
                    <div class="input-group col-md-6 d-flex mb-3">
                        <span class="input-group-btn mr-2">
                            <button type="button" class="quantity-left-minus btn" data-type="minus">
                                <i class="icon-minus"></i>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                        <span class="input-group-btn ml-2">
                            <button type="button" class="quantity-right-plus btn" data-type="plus">
                                <i class="icon-plus"></i>
                            </button>
                        </span>
                    </div>
                    <div id="cartMessage" class="alert-container" style="display: none;"></div>
                    <form action="{{ route('add.cart', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="pro_id" value="{{ $product->id }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <input type="hidden" name="description" value="{{ $product->description }}">
                        <input type="hidden" name="image" value="{{ $product->image }}">
                        <button type="submit" class="btn btn-custom py-3 px-5">Add to Cart</button>
                    </form>
                    @else
                    <div class="w-100"></div>
                    <div class="input-group col-md-6 d-flex mb-3">
                        <span class="input-group-btn mr-2">
                            <button type="button" class="quantity-left-minus btn" style="pointer-events: none; opacity: 0.5;" data-type="minus">
                                <i class="icon-minus"></i>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" disabled value="1" min="1" max="100">
                        <span class="input-group-btn ml-2">
                            <button type="button" class="quantity-right-plus btn" style="pointer-events: none; opacity: 0.5;" data-type="plus">
                                <i class="icon-plus"></i>
                            </button>
                        </span>
                    </div>
                    <button id="add-to-cart" data-product-id="{{ $product->id }}" class="text-white btn btn-warning py-3 px-5" style="pointer-events: none; opacity: 0.5; color: #fff !important;">Added to Cart</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <span class="subheading">Discover</span>
                <h2 class="mb-4">Related products</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
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
                        <p><a href="{{ route('product.single', $relatedProduct->id) }}" class="btn btn-primary btn-outline-primary">Add to Cart</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Increment/Decrement Quantity
        $('.quantity-left-minus').click(function() {
            var quantity = parseInt($('#quantity').val());
            if (quantity > 1) {
                $('#quantity').val(quantity - 1);
            }
        });

        $('.quantity-right-plus').click(function() {
            var quantity = parseInt($('#quantity').val());
            if (quantity < 100) {
                $('#quantity').val(quantity + 1);
            }
        });

        // Add to Cart
        $('#add-to-cart').click(function() {
            var productId = $(this).data('product-id');
            var quantity = $('#quantity').val(); // Get the quantity from the input field

            $.ajax({
                url: '{{ route('add.cart', '') }}/' + productId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity // Include quantity in the data
                },
                success: function(response) {
                    $('#cartMessage').html('<div class="alert alert-success">Item added to cart</div>').fadeIn();
                    setTimeout(function() {
                        $('#cartMessage').fadeOut('slow');
                        location.reload(); // Refresh the page after 5 seconds
                    }, 5000); // Auto-hide after 5 seconds
                },
                error: function(response) {
                    console.log(response); // Log the full error response for debugging
                    $('#cartMessage').html('<div class="alert alert-danger">There was an error adding the item to the cart</div>').fadeIn();
                    setTimeout(function() {
                        $('#cartMessage').fadeOut('slow');
                    }, 5000); // Auto-hide after 5 seconds
                }
            });
        });
    });
</script>

@endsection
