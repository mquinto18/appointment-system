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
                .email-border{
                    border-bottom: 4px solid #0074c8;;
                }
                .email-signature{
                    padding: 5px 0px;
                    line-height: 5px;
                }
                .email-thankyou{
                    padding-top: 15px;
                }
                .email-logo{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 10px;
                    margin: 20px 0;
                }
                .email-title{
                    font-size: 14px;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
            <div class="email-logo">
                <table style="width: 100%; text-align: center; margin: 0 auto;">
                    <tr>
                        <td>
                            <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="Logo" style="width: 60px; display: block; margin: 0 auto;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h1 style="font-size: 14px; font-style: italic; font-weight: 500;">
                                St. Benedict Medical <br> Clinic & Pharmacy
                            </h1>
                        </td>
                    </tr>
                </table>
            </div>
                <div class="email-header">
                    <h1>Appointment Confirmed</h1>
                </div>
                <div class="email-border">
                    <div class="email-content">
                        <p>
                            We are pleased to inform you that your appointment with
                            Dr. {{ $details['doctor'] }} has been successfully approved.
                            Below are the details of your appointment:
                        </p>

                        <div>
                            <h4>Appointment Details:</h4>
                            <ul>
                                <li>Date: {{ \Carbon\Carbon::parse($details['appointment_date'])->format('F j, Y') }}</li>
                                <li>Time: {{ \Carbon\Carbon::parse($details['appointment_time'])->format('h:i A') }}</li>
                            </ul>
                        </div>

                        <div>
                            <h4>Additional Information:</h4>
                            <ul>
                                <li>
                                    Please arrive 10–15 minutes before your
                                    scheduled time to allow for check-in.
                                </li>
                                <li>
                                    Bring any relevant documents or medical history
                                    for your consultation
                                </li>
                                <li>
                                    If you need to reschedule or cancel your
                                    appointment, kindly inform us at least 24 hours
                                    in advance.
                                </li>   
                            </ul>
                        </div>

                        <div>
                            <p class="email-thankyou">
                                Thank you for choosing St. Benedict Medical Clinic &
                                Pharmacy. We look forward to seeing you!
                            </p>
                            <div class="email-signature">
                                <p>Your's in Health</p>
                                <p>St. Benedict Care</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="email-footer">
                    &copy; Copyright {{ date('Y') }} Doctor Anywhere, All rights reserved.

                    <p>CONFIDENTIAL NOTE: The information contained in this email is intended only for the use of the individual or entity named above and may contain information that is privileged, confidential and exempt from disclosure under applicable law. If the reader of this message is not the intended recipient, you are hereby notified that any dissemination, distribution or copying of this communication is strictly prohibited. If you have received this message in error, please immediately notify the sender and delete the mail. Thank you.</p>
                </div>
            </div>
        </body>
    </html>
