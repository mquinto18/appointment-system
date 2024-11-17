<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment QR Code</title>
    <style>
        /* Add basic styling for PDF */
        body { font-family: sans-serif; }
        .qr-code { text-align: center; margin: 20px 0; }
    </style>
</head>
<body>
<div class="qr-code">
    <h2>QR Code</h2>
    <img src="{{ $qrCode }}" alt="QR Code">
</div>

<div class="appointment-details">
    <p>Transaction Number: {{ $appointment->transaction_number }}</p>
    <p>Name: {{ $appointment->first_name }} {{ $appointment->last_name }}</p>
    <p>Date: {{ $appointment->appointment_date }}</p>
    <!-- Add other appointment details as needed -->
</div>
</body>
</html>
