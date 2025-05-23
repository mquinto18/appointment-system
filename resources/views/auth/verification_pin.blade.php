<!DOCTYPE html>
<html>
<head>
    <title>Your Verification PIN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0074C8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #4caf50;
            color: #fff;
            text-align: center;
            padding: 15px 20px;
        }
        .email-content {
            padding: 20px;
            text-align: center;
        }
        .email-content h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .email-content p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .email-pin {
            display: inline-block;
            background-color: #e0f7fa;
            color: #00796b;
            font-size: 28px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            border: 1px solid #b2ebf2;
            margin-top: 10px;
        }
        .email-footer {
            background-color: #f9f9f9;
            text-align: center;
            padding: 15px 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Your Verification PIN</h1>
        </div>
        <div class="email-content">
            <p>Please use the following PIN to verify your account:</p>
            <div class="email-pin">{{ $pin }}</div>
            <p>Thank you!</p>
        </div>
        <div class="email-footer">
            <p>If you did not request this verification, please ignore this email.</p>
        </div>
    </div>
</body>
</html>
