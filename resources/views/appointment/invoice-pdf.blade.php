<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Billing Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            
            align-items: center;
            margin-bottom: 30px;
        }
        .header img {
            width: 100px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #0074C8;
            text-transform: uppercase;
            text-align: right;
        }
        .sub-header {
            border-top: 4px solid #0074C8;
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        .info-table th {
            font-weight: bold;
        }
        .info-table td {
            font-size: 14px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table th, .invoice-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .invoice-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            text-transform: uppercase;
        }
        .invoice-total {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            text-align: left;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Clinic Logo" class="w-[65px]">
            <h1>Medical Billing Invoice</h1>
        </div>

        <div class="sub-header"></div>

        <table class="info-table">
            <tr>
                <td>
                    <strong>Patient Information</strong><br>
                    {{ $first_name }} {{ $last_name }}<br>
                    {{ $contact_number }}<br>
                    {{ $complete_address }}
                </td>
                <td>
                    <strong>Physician's Information</strong><br>
                    Dr. Malyn Basbas-Uy<br>
                    License No: 98388<br>
                    Villa Cuana 1, Phase 1, Pasig City
                </td>
                <td>
                    <strong>Invoice No: #{{ $transaction_number }}</strong><br>
                    Bill Date: {{ $appointment_date }}<br>
                    Bill Time: {{ $appointment_time }}<br>
                    Bill Type: Cash
                </td>
            </tr>
        </table>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($descriptions as $index => $description)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $description }}</td>
                        <td>{{ $quantities[$index] }}</td>
                        <td>{{ number_format($amounts[$index], 2) }}</td>
                        <td>{{ number_format($quantities[$index] * $amounts[$index], 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="invoice-total">Subtotal</td>
                    <td>{{ number_format(collect($quantities)->zip($amounts)->sum(fn($pair) => $pair[0] * $pair[1]), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="invoice-total">Discount</td>
                    <td><p>{{ $discount }}%</p></td>
                </tr>
                <tr>
                    <td colspan="4" class="invoice-total">Total Amount</td>
                    <td>{{ number_format($discountedAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>    

        <div class="footer">
            <p class='text-red-500'><strong>Prepared by:</strong> [Admin Name]</p>
            <p><strong>Date of Issue:</strong> {{ now()->toDateString() }}</p>
            <p>Thank you for choosing St. Benedict Medical Clinic & Pharmacy!</p>
        </div>
    </div>
</body>
</html>
