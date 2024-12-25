<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 70px;
            color: rgba(0, 0, 0, 0.1);
            font-weight: bold;
            z-index: -1;
            letter-spacing: 10px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        h2 {
            color: #34495e;
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        ul {
            padding: 0;
            list-style: none;
            text-align: left;
            font-size: 14px;
        }

        li {
            margin-bottom: 5px;
        }

        .product-list {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
            margin-top: 40px;
            color: #7f8c8d;
        }

        .footer a {
            color: #7f8c8d;
            text-decoration: none;
        }

        /* Stylish links */
        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Watermark -->
        <div class="watermark">Receipt</div>

        <h1>Thank you for your purchase, {{ $order->firstname }} {{ $order->lastname }}!</h1>
        <p>Order Summary:</p>
        <ul>
            <li>Order ID: {{ $order->id }}</li>
            <li>Total Price: ${{ number_format($order->total_price, 2) }}</li>
            <li>Date: {{ $order->created_at->format('d-m-Y') }}</li>
        </ul>

        <h2>Items Purchased</h2>
        <table class="product-list">
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
                @foreach ($order->orderItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Total Amount: ${{ number_format($totalWithDiscount, 2) }}</p>
        </div>

        <p>Please find your detailed receipt attached to this email.</p>

        <p>If you have any questions or need further assistance, feel free to reach out to us at <a href="mailto:{{ env('APP_SUPPORT_MAIL') }}">{{ env('APP_SUPPORT_MAIL') }}</a>.</p>

        <div class="footer">
            <p>Best regards, <br><a href="{{ config('app.fullname') }}">{{ config('app.fullurl') }}</a></p>
            <p>Thank you for choosing us!</p>
        </div>
    </div>

</body>
</html>
