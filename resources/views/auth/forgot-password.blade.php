<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .message {
            font-size: 16px;
            color: #555;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #0074C8;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056A4;
        }
        .footer {
            font-size: 14px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="header">Reset Your Password</p>
        <p class="message">You requested a password reset. Click the button below to reset your password:</p>
        <a href="{{ $resetUrl }}" class="button" style="display: inline-block; padding: 12px 20px; background-color: #0074C8; color: #FFFFFF !important; text-decoration: none; border-radius: 6px; font-size: 16px; font-weight: bold; text-align: center;">
            Reset Password
        </a>
        <p class="message">If you did not request this, please ignore this email.</p>
        <p class="footer">Regards,<br>St, Benedict Medical Clinic</p>
    </div>
</body>
</html>
