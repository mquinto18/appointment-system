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
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 100px; /* Adjust the logo size */
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .certificate-title {
            font-size: 28px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info strong {
            display: inline-block;
            width: 200px; /* Align labels */
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .footer p {
            margin: 5px 0;
        }
        .disclaimer {
            font-size: 10px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('path/to/your/logo.png') }}" alt="Logo"> <!-- Add your logo path -->
        <h2>St. Benedict Medical Clinic & Pharmacy</h2>
    </div>
    
    <div class="certificate-title">MEDICAL CERTIFICATE</div>

    <div class="info">
        <strong>Medical Certificate ID:</strong> {{ $appointment->id }}<br>
        <strong>Date of Consultation:</strong> {{ $appointment_date }}<br>
        <strong>Time of Consultation:</strong> {{ $appointment_time }}<br>
        <strong>Patient Name:</strong> {{ $patient_name }}<br>
        <strong>Birthday:</strong> {{ $date_of_birth }}<br>
        <strong>Age:</strong> {{ $age }}<br>
        <strong>Gender:</strong> {{ $gender }}<br>
        <strong>Address:</strong> {{ $address }}<br>
    </div>

    <p>This is to certify that the above-named patient was evaluated with the following findings.</p>

    <div class="info">
        <strong>Diagnosis:</strong> {{ $diagnosis }}<br>
        <strong>Remarks:</strong> _________________________<br>
    </div>

    <div class="footer">
        <p>Certified By:</p>
        <p>Malyn Basbas-Uy MD</p>
        <p>License No.: 98388</p>
    </div>

    <div class="disclaimer">
        This medical certificate was issued upon request of the patient for whatever purpose it may serve except for medico-legal, and subject to the limitations indicated below.
    </div>
</body>
</html>
