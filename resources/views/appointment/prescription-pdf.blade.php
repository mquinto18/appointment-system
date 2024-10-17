<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            padding: 20px;
            margin: 20px auto;
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-left {
            display: flex;
            align-items: center;
        }
        .header-left img {
            height: 60px;
            margin-right: 20px;
        }
        .header-left h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header-right h2 {
            font-size: 16px;
            color: #0056b3;
            text-transform: uppercase;
        }
        .rx-container {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .rx-symbol {
            font-size: 64px;
            font-weight: bold;
            color: #000;
        }
        .patient-info {
            width: 70%;
            line-height: 1.6;
        }
        .patient-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }
        .details h2 {
            color: #2f855a;
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #2f855a;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with logo and title -->
        <div class="header">
            <div class="header-left">
                <img src="logo.png" alt="Clinic Logo"> <!-- Add your logo here -->
                <h2>St. Benedict Medical Clinic & Pharmacy</h2>
            </div>
            <div class="header-right">
                <h2>DOCTORS PRESCRIPTION</h2>
            </div>
        </div>

        <!-- Rx Symbol and Patient Info -->
        <div class="rx-container">
            <div class="rx-symbol">
                Rx
            </div>
            <div class="patient-info">
                <p><strong>Patient Name:</strong> {{ $first_name }} {{ $last_name }}</p>
                <p><strong>Date of Birth:</strong> {{ $date_of_birth }}</p>
                <p><strong>Age:</strong> {{ $age }} years</p>
                <p><strong>Address:</strong> {{ $complete_address }}</p>
            </div>
        </div>

        <!-- Prescription Details Table -->
        <div class="details">
            <h2>Prescription Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Drug Name</th>
                        <th>Dosage</th>
                        <th>Quantity</th>
                     
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drugname as $index => $drug)
                        <tr>
                            <td>{{ $drug }}</td>
                            <td>{{ $dosage[$index] }}</td>
                            <td>{{ $doctorqty[$index] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Prescription generated on {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>
