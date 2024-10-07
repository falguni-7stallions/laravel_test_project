<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <style>
        body {
            background-color: #f2f7f9;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #e8f1f2;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #556677;
        }
        .content {
            padding: 30px 20px;
        }
        .content h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #556677;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #667788;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            background-color: #6ec1e4;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .footer {
            background-color: #e8f1f2;
            padding: 20px;
            text-align: center;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            font-size: 14px;
            color: #99aabb;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Welcome to {{ config('app.name') }}!</h1>
    </div>
    <div class="content">
        <h2>Hello, {{ $user->name }}!</h2>
        <p>We're thrilled to have you join us. At {{ config('app.name') }}, we strive to provide the best experience for our users.</p>
        <p>If you need any assistance or have questions, don’t hesitate to reach out. We're here for you!</p>
        <div class="button-container">
            <a href="{{ url('/') }}" class="btn">Get Started</a>
        </div>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
</body>
</html>
