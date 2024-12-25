<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            background-image: url({{ asset('assets/images/bg_1.jpg') }});
            background-size: cover;
            background-position: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
        }
        h2 {
            color: #34495e;
            font-size: 18px;
            margin-bottom: 10px;
        }
        p {
            font-size: 14px;
            line-height: 1.5;
        }
        ul {
            padding: 0;
            list-style: none;
        }
        li {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .product-list th, .product-list td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .product-list th {
            background-color: #f1f1f1;
        }
        .total {
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 30px;
            color: #7f8c8d;
        }
        /* Slider Styles */
        .slider-container {
            max-width: 100%;
            position: relative;
            margin-top: 20px;
            display: block;
            overflow: hidden;
        }
        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .slider img {
            width: 100%;
            height: auto;
        }
        .slider-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
            transform: translateY(-50%);
        }
        .slider-nav button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .slider-nav button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dear {{ $order->firstname }},</h1>

        <p>Thank you for your recent purchase from {{ env('APP_FULL_NAME') }}! We are pleased to confirm your order with the following details:</p>

        <div class="order-summary">
            <h2>Order Details</h2>
            <ul>
                <li>Order ID: <strong>{{ $order->id }}</strong></li>
                <li>Date of Purchase: {{ $order->created_at->format('Y-m-d') }}</li>
                <li>Total Price: ${{ number_format($order->total_price, 2) }}</li>
            </ul>
        </div>

        <div class="product-list">
            <h2>Items Purchased</h2>
            <table width="100%" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th>{{ __('#') }}</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price per Item</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as  $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total">
            <p><strong>Total Amount: ${{ number_format($totalWithDiscount, 2)}}</strong></p>
        </div>

        <p>Please find your detailed receipt attached to this email.</p>

        <p>If you have any questions or need further assistance, feel free to reach out to us at <a href="mailto:{{ env('APP_SUPPORT_MAIL') }}">{{ env('APP_SUPPORT_MAIL') }}</a>.</p>

        <div class="slider-container">
            <div class="slider" id="slider">
                <img src="{{ asset('assets/images/bg_1.jpg') }}" alt="Slider Image 1">
                <img src="{{ asset('assets/images/bg_2.jpg') }}" alt="Slider Image 2">
                <img src="{{ asset('assets/images/bg_3.jpg') }}" alt="Slider Image 3">
            </div>
            <div class="slider-nav">
                <button onclick="moveSlider(-1)">&#10094;</button>
                <button onclick="moveSlider(1)">&#10095;</button>
            </div>
        </div>

        <div class="footer">
            <p>Best regards,<br><a href="{{ config('app.fullname') }}">{{ config('app.fullurl') }}</a></p>
            <p>Thank you for choosing us!</p>
            <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All right reserved.</p>
        </div>
    </div>

    <script>
        let currentSlide = 0;

        function moveSlider(direction) {
            const slides = document.querySelectorAll('.slider img');
            const totalSlides = slides.length;
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            document.getElementById('slider').style.transform = `translateX(-${currentSlide * 100}%)`;
        }
    </script>
</body>
</html>
