<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Follow-Up Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #0074c8;
            color: #fff;
            text-align: center;
            padding: 5px 20px;
        }
        .email-content {
            padding: 20px;
        }

        .email-footer {
            background-color: #f9f9f9;
            text-align: center;
            padding: 15px 20px;
            font-size: 12px;
            color: #888;
        }
        .email-border {
            border-bottom: 4px solid #0074c8;
        }
        .email-signature {
            padding: 5px 0px;
            line-height: 5px;
        }
        .email-thankyou {
            padding-top: 15px;
        }
        .email-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }
        .email-title {
            font-size: 14px;
        }

        .email-message div {
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-logo">
            <table style="width: 100%; text-align: center; margin: 0 auto">
                <tr>
                    <td>
                        <img
                            src="{{ $message->embed(public_path('images/logo.png')) }}"
                            alt="Logo"
                            style="width: 60px; display: block; margin: 0 auto;"
                        />
                    </td>
                </tr>
                <tr>
                    <td>
                        <h1
                            style="font-size: 14px; font-style: italic; font-weight: 500;">
                            St. Benedict Medical <br />
                            Clinic & Pharmacy
                        </h1>
                    </td>
                </tr>
            </table>
        </div>
        <div class="email-header">
            <h1>Follow-Up Appointment Confirmation</h1>
        </div>
        <div class="email-border">
            <div class="email-content">
                <div>
                    <p>Dear {{ $appointment->first_name }} {{ $appointment->last_name }},</p>
                </div>

                <div>
                    <p>We hope this email finds you well.</p>
                </div>

                <div class="email-message">
                    <div>
                        We are writing to confirm your follow-up appointment with us on
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }} at
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}.
                    </div>
                    <div>
                        Visit Type: {{ $appointment->visit_type }}
                    </div>
                    <div>
                        Doctor: {{ $appointment->doctor ?? 'Not Assigned' }}
                    </div>
                    <div>
                        If you have any questions or need to reschedule, please do not hesitate to contact us.
                    </div>
                    <div>
                        Thank you for choosing our clinic for your healthcare needs. We look forward to seeing you.
                    </div>
                </div>

                <div>
                    <div class="email-signature">
                        <p>Your's in Health</p>
                        <p>St. Benedict Care</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="email-footer">
            &copy; Copyright {{ date('Y') }} St. Benedict Medical Clinic, All rights reserved.
            <p>
                CONFIDENTIAL NOTE: The information contained in this email is intended only for the use of the individual or entity named above and may contain information that is privileged, confidential and exempt from disclosure under applicable law. If the reader of this message is not the intended recipient, you are hereby notified that any dissemination, distribution or copying of this communication is strictly prohibited. If you have received this message in error, please immediately notify the sender and delete the mail. Thank you.
            </p>
        </div>
    </div>
</body>
</html>
