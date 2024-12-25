@extends('layouts.app')

@section('styles')

<style>
    #card-element {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }
</style>

@endsection

@section('content')
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Pay with Stripe</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Pay with Stripe</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <form id="payment-form">
        <div id="card-element">
            <!-- Stripe card input will be inserted here -->
        </div>
        <button id="submit" class="btn btn-primary mt-4">Pay Now</button>
    </form>
    <div id="payment-message" class="d-none"></div>
</div>

<!-- Stripe JS SDK -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        if (form) {
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                });

                const paymentMessage = document.getElementById('payment-message');

                if (error) {
                    paymentMessage.innerText = error.message;
                    paymentMessage.classList.remove('d-none');
                } else {
                    fetch('{{ route('stripe.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_method: paymentMethod.id,
                            amount: '{{ Session::get('price', 0) * 100 }}' // amount in cents
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '{{ route('products.payment.success') }}';
                        } else {
                            paymentMessage.innerText = 'Payment failed. Please try again.';
                            paymentMessage.classList.remove('d-none');
                        }
                    });
                }
            });
        }
    });
</script>
@endsection

@section('styles')
<style>
    #payment-message {
        display: none;
        padding: 15px;
        margin: 15px 0;
        border: 1px solid #d9534f;
        border-radius: 4px;
        background-color: #f2dede;
        color: #a94442;
        font-size: 16px;
        text-align: center;
    }
</style>
@endsection
