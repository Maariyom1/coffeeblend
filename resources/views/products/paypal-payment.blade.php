@extends('layouts.app')

@section('content')
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Pay with PayPal</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Pay with PayPal</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <!-- PayPal SDK Script -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
    <!-- PayPal Button Container -->
    <div id="paypal-button-container"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var price = '{{ Session::get('price', 0) }}'; // Default to 0 if not set
            console.log('Price:', price); // Debug information

            if (price > 0) {
                console.log('Initializing PayPal Buttons...'); // Debug information

                paypal.Buttons({
                    createOrder: (data, actions) => {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: price
                                }
                            }]
                        });
                    },
                    onApprove: (data, actions) => {
                        console.log('Order approved:', data); // Debug information
                        return actions.order.capture().then(function(orderData) {
                            window.location.href = '{{ route('products.payment.success') }}';
                        }).catch(function(error) {
                            console.error('Payment failed:', error);
                            var messageElement = document.getElementById('paypal-message');
                            messageElement.innerHTML = '<p>Payment could not be processed. Please try again.</p>';
                            messageElement.classList.remove('d-none'); // Show the message
                        });
                    },
                    onError: (err) => {
                        console.error('PayPal error:', err); // Debug information
                        var messageElement = document.getElementById('paypal-message');
                        messageElement.innerHTML = '<p>An error occurred with PayPal. Please try again later.</p>';
                        messageElement.classList.remove('d-none'); // Show the message
                    }
                }).render('#paypal-button-container');
            } else {
                var messageElement = document.getElementById('paypal-message');
                messageElement.innerHTML = '<p>No price available. Please try again.</p>';
                messageElement.classList.remove('d-none'); // Show the message
                console.log('No price available'); // Debug information
            }
        });
    </script>
@endsection

@section('styles')
<style>
    #paypal-message {
        display: none; /* Hidden by default */
        padding: 15px;
        margin: 15px 0;
        border: 1px solid #f0ad4e;
        border-radius: 4px;
        background-color: #fcf8e3;
        color: #8a6d3b;
        font-size: 16px;
        text-align: center;
    }
</style>
@endsection
