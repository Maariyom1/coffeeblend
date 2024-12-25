<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Update Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Update Successful</h1>
        </div>
        <div class="content">
            <p>Dear {{ Auth::user()->name }},</p>
            <p>Your email address has been successfully updated to <strong>{{ $new_email }}</strong>.</p>
            <p>If you did not request this change, please contact our support team immediately.</p>
            <p>Thank you for using our service!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Coffee Blend. All rights reserved.</p>
            <p><a href="{{ url('/home') }}">Back to Homepage</a> | <a href="{{ route('user-profile') }}">Back to Profile</a></p>
        </div>
    </div>
</body>
</html>
