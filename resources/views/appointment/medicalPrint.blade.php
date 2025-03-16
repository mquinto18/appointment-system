<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            position: relative;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Place behind content */
            background: url('{{ public_path('images/logo.png') }}') no-repeat center;
            background-size: 500px; /* Adjust size as needed */
            opacity: 0.1; /* Adjust opacity for the background image */
        }

        .header {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 3px solid black;
        }

        .header img {
            width: 80px; /* Adjust the logo size */
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .certificate-title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 30px;
            font-style: italic;
        }

        .info {
            margin-bottom: 20px;
        }

        .info strong {
            display: inline-block;
            width: 200px; /* Align labels */
            padding: 10px 0;
        }

        .footer {
            margin-top: 30px;
            
        }

        .footer p {
            margin: 5px 0;
        }

        .disclaimer {
            font-size: 15px;
            margin-top: 20px;
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid black; 
            color: rgb(134, 129, 129);
        }
        .border-top{
            background-color: ;
        }
        .text0button{
            text-align: center;
            font-style: italic;
            color: rgb(134, 129, 129);
            font-size: 15px;
        }
        .float-bottom{
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="border-top"></div>
    <div class="background"></div> <!-- Background image with opacity -->

    <div class="header">
        <table>
            <tr>
                <td><img src="{{ public_path('images/logo.png') }}" alt="Logo"></td>
                <td> 
                    <h1 style="font-size: 14px; font-style: italic; font-weight: 500; font-weight: bold;">
                        St. Benedict Medical <br> Clinic & Pharmacy
                    </h1>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="certificate-title">MEDICAL CERTIFICATE</div>
    
    <div>
        <table style="width: 100%;">
            <tr>
              <td colspan="2" style="padding: 5px; font-weight: bold;">
                <strong>Medical Certificate ID:</strong> {{ $appointment->id }}
              </td>
            </tr>
            <tr>
              <td style="padding: 5px;">
              <strong>Date of Consultation:</strong> {{ $appointment_date }}
              </td>
              <td style="padding: 5px;">
              <strong>Time of Consultation:</strong> {{ $appointment_time }}
              </td>
            </tr>
            <tr>
              <td colspan="2" style="padding: 5px;">
              <strong>Patient Name:</strong> {{ $patient_name }}
              </td>
            </tr>
            <tr>
              <td colspan="2" style="padding: 5px;">
              <strong>Address:</strong> {{ $address }}
              </td>
            </tr>
            <tr>
              <td style="padding: 5px;">
              <strong>Birthday:</strong> {{ $date_of_birth }}
              </td>
              <td style="padding: 5px;">
              Age:</strong> {{ $age }}
              </td>
              <td style="padding: 5px;">
              <strong>Gender:</strong> {{ $gender }}
              </td>
            </tr>
          </table>
    </div>

   

    <p class="text0button">This is to certify that the above-named patient was evaluated with the following findings.</p>

    <div class="info">
        <strong>Diagnosis:</strong> <br>{{ $diagnosis }}<br>
        <strong>Remarks:</strong><br>
    </div>

    <div class="footer">
        <p>Certified By:</p>
        <img src="{{ public_path('images/signature.png') }}" alt="Logo" style="width: 105px;">
        <p>Malyn Basbas-Uy MD</p>
        <p>License No.: 98388</p>
    </div>

    <div class="float-bottom">
        <div class="disclaimer">
            This medical certificate was issued upon request of the patient for whatever purpose it may serve except for medico-legal, and subject to the limitations indicated below.
        </div>

        <div style="display: flex; justify-content: center; align-items: center; padding: 20px 0;">
            <table>
                <tr>
                    <td><img src="{{ public_path('images/call.png') }}" alt="Logo" style="width: 35px;"></td>
                    <td style="padding: 10px;"> 
                        <h1 style="font-size: 10px; font-style: italic; font-weight: 500; font-weight: bold;">
                            <strong>Phone</strong> <br> +63 (950) 678 5969
                        </h1>
                    </td>
                    <td><img src="{{ public_path('images/email.png') }}" alt="Logo" style="width: 35px;"></td>
                    <td style="padding: 10px;"> 
                        <h1 style="font-size: 10px; font-style: italic; font-weight: 500; font-weight: bold;">
                            <strong>Email</strong> <br> stbenedictmedicalclinic.gmail.com
                        </h1>
                    </td>
                    <td><img src="{{ public_path('images/location.png') }}" alt="Logo" style="width: 35px;"></td>
                    <td style="padding: 10px;"> 
                        <h1 style="font-size: 10px; font-style: italic; font-weight: 500; font-weight: bold;">
                            <strong>Address</strong> <br> Villa Cuana Phase 1, Barangay San Andres, Cainta, Rizal
                        </h1>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
</body>
</html>
