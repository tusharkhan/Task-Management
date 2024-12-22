<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2024
 */
?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .body {
            padding: 20px;
            color: #333333;
        }
        .body p {
            margin: 0 0 15px;
            line-height: 1.5;
        }
        .body a {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }
        .body a:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            background-color: #f4f4f4;
            padding: 10px;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="header">
        <h1>Welcome to {{$brand_name}}!</h1>
    </div>

    <!-- Body -->
    <div class="body">
        <p>Hi {{$user->name}},</p>
        <p>Thank you for registering with {{$brand_name}}! We’re excited to have you on board. This link will expires on <span style="color: #0c66ff">{{ date('Y-m-d', strtotime($expires_at)) }}</span>  </p>
        <p>Please confirm your email address to activate your account:</p>
        <a href="{{ $link }}" target="_blank">Confirm Email Address</a>
        <p>If you did not create an account, you can safely ignore this email.</p>
        <p>Best regards,</p>
        <p>The {{$brand_name}} Team</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{$brand_name}}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
