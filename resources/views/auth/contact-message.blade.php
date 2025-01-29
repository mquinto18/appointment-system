<!DOCTYPE html>
<html>
<head>
    <title>Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #0074C8;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-content {
            padding: 20px;
            line-height: 1.6;
        }
        .email-content h2 {
            margin-top: 0;
            font-size: 20px;
            color: #0074C8;
        }
        .email-content p {
            margin: 10px 0;
            font-size: 16px;
        }
        .email-footer {
            background-color: #f4f4f9;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
        }
        .email-footer a {
            color: #0074C8;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>New Contact Message</h1>
        </div>
        <div class="email-content">
            <h2>Details:</h2>
            <p><strong>Full Name:</strong> {{ $data['full_name'] }}</p>
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Message:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>
        <div class="email-footer">
            <p>This message was sent from the contact form on your website.</p>
            <p><a href="#">Visit Your Website</a></p>
        </div>
    </div>
</body>
</html>
