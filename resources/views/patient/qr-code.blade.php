<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your styles for the PDF here */
    </style>
</head>
<body>
    <h1>Appointment Details</h1>
    <p>Appointment Name: {{ $appointment->first_name }} {{ $appointment->last_name }}</p>
    <p>Visit Type: {{ $appointment->visit_type }}</p>
    <p>Schedule Date: {{ $appointment->appointment_date }}</p>
    <p>Address: {{ $appointment->complete_address }}</p>

    <h3>QR Code:</h3>
    
    <img src="{{ $qrCodeDataUri }}" alt="QR Code" />
</body>
</html>
