<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            font-size: 16px;
            margin: 0;
            padding: 20px;
            background-color: #f9fafb;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .date-range {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #cbd5e0;
            padding: 8px;
            text-align: left;
        }
        thead {
            background-color: #4299e1;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f7fafc;
        }
        tr:hover {
            background-color: #e2e8f0;
        }
        .total-row {
            font-weight: bold;
            background-color: #edf2f7;
        }
        .total-cell {
            text-align: right;
            padding-right: 16px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>MABALACAT DORM: SALES REPORT</h1>
    <!-- Date Range -->
    <p class="date-range">
        Report Period: {{ date('F j, Y', strtotime($startDate)) }} - {{ date('F j, Y', strtotime($endDate)) }}
    </p>

    <!-- Sales Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->full_name }}</td>
                <td>Php: {{ number_format($payment->amount, 2) }}</td>
            </tr>
            @endforeach
            <!-- Total Revenue Row -->
            <tr class="total-row">
                <td colspan="2" class="total-cell">Overall Total</td>
                <td>Php: {{ number_format($totalRevenue, 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>
