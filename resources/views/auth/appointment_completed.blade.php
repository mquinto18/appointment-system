<!DOCTYPE html>
<html>
<head>
    <title>Appointment Completed Notification</title>
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
            background-color: #0074C8;
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
            <h1>Appointment Completed</h1>
        </div>
        <div class="email-content">
            <p>Dear {{ $details['name'] }},</p>
            <p>Your appointment on {{ \Carbon\Carbon::parse($details['appointment_date'])->format('F j, Y') }} has been successfully completed.</p>
            <p>Status: <strong>{{ ucfirst($details['status']) }}</strong></p>
            <p>Details:</p>
            <ul style="list-style-type: none; padding: 0;">
                <li><strong>Sample Number:</strong> 09695194016 </li>
                <li><strong>Doctor's Name:</strong> Dr. Malyn Basbas-Uy</li>
                <li><strong>Doctor's License No:</strong> 98388</li>
                <li><strong>Clinic Address:</strong> Villa Cuana 1, Phase 1, Pasig City</li>
            </ul>
            <p>If you have any questions or need further assistance, feel free to contact us.</p>
            <p>Thank you for trusting St. Benedict Medical Clinic & Pharmacy with your healthcare needs!</p>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} St. Benedict Medical Clinic & Pharmacy. All rights reserved.
        </div>
    </div>
</body>
</html>
