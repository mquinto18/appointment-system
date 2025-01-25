<!DOCTYPE html>
<html>
    <head>
        <title>Appointment Completed Notification</title>
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
                                style="
                                    width: 60px;
                                    display: block;
                                    margin: 0 auto;
                                "
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h1
                                style="
                                    font-size: 14px;
                                    font-style: italic;
                                    font-weight: 500;
                                "
                            >
                                St. Benedict Medical <br />
                                Clinic & Pharmacy
                            </h1>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="email-header">
                <h1>Appointment Completed</h1>
            </div>
            <div class="email-border">
                <div class="email-content">
                    <div>
                        <p>Dear {{ $details['name'] }},</p>
                    </div>

                    <div>
                        <p>We hope this email finds you well.</p>
                    </div>

                    <div class="email-message">
                        <div>
                            We are writing to confirm that your appointment on
                            {{
                            \Carbon\Carbon::parse($details['appointment_date'])->format('F
                            j, Y') }} Dr. Malyn Basbas-Uy at St. Benedict
                            Medical Clinic & Pharmacy has been successfully
                            completed.
                        </div>
                        <div>
                            If you have any further concerns or need follow-up
                            care, please don’t hesitate to reach out to us. You
                            may contact our clinic at 09123456789.
                        </div>
                        <div>
                            Thank you for trusting us with your healthcare
                            needs. We value your feedback and would greatly
                            appreciate it if you could take a few moments to
                            share your experience on your Online Portal.
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
                &copy; Copyright {{ date('Y') }} Doctor Anywhere, All rights reserved.

                <p>
                    CONFIDENTIAL NOTE: The information contained in this email
                    is intended only for the use of the individual or entity
                    named above and may contain information that is privileged,
                    confidential and exempt from disclosure under applicable
                    law. If the reader of this message is not the intended
                    recipient, you are hereby notified that any dissemination,
                    distribution or copying of this communication is strictly
                    prohibited. If you have received this message in error,
                    please immediately notify the sender and delete the mail.
                    Thank you.
                </p>
            </div>
        </div>
    </body>
</html>
