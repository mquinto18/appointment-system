<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Transaction History</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Gender</th>
                <th>Appointment Date</th>
                <th>Visit Type</th>
                <th>Amount</th>
                <th>Discount</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalSales = 0;
            @endphp
            @foreach ($appointments as $appointment)
                @php
                    $amount = json_decode($appointment->amount, true);
                    $totalAmount = is_array($amount) ? array_sum($amount) : 0;
                    $discount = $appointment->discount ?? 0;
                    $discountAmount = ($totalAmount * $discount) / 100;
                    $finalAmount = $totalAmount - $discountAmount;
                    $totalSales += $finalAmount;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                    <td>{{ ucfirst($appointment->gender) }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->visit_type }}</td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
                    <td>{{ $discount }}%</td>
                    <td>{{ number_format($finalAmount, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">  
                <td colspan="7" style="text-align: right;">Total Sales:</td>
                <td>{{ number_format($totalSales, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
