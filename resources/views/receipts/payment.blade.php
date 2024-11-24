<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Apartment System</title>
    <style>
         h1 {
            text-align: center; /* Center align the title */
            font-size: 2rem; /* Increase font size for the title */
            margin: 1rem 0; /* Add margin above and below the title */
            color: #4A90E2; /* A shade of blue for the title */
        }
        h4 {
            margin: 0;
        }
        .w-full {
            width: 100%;
        }
        .w-half {
            width: 50%;
        }
        .margin-top {
            margin-top: 1.25rem;
        }
        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241, 245, 249);
        }
        table {
            width: 100%;
            border-spacing: 0;
        }
        table.products {
            font-size: 0.875rem;
        }
        table.products tr {
            background-color: rgb(96, 165, 250);
        }
        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }
        table tr.items {
            background-color: rgb(241, 245, 249);
        }
        table tr.items td {
            padding: 0.5rem;
            text-align: center; /* Center align text in all table data cells */
        }
        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
        }
        /* Set height and width for the logo */
        .w-16 {
            width: 60px;  /* Set width to 16 pixels */
            height: 60px; /* Set height to 16 pixels */
        }
    </style>
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src="{{ public_path('admin_assets/assets/images/logo/logo.png') }}" alt="Logo" class="w-16 mx-auto">
            </td>
            <td class="w-half">
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><h4>To:</h4></div>
                    <div> {{ $payment->full_name }}</div>
                </td>
                <td class="w-half">
                    <div><h4>From:</h4></div>
                    <div>Apartment System</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Amount Paid</th>
                <th>Date</th>
            </tr>
            <tr class="items">
                <td>
                    Php{{ number_format($payment->amount, 2) }}
                </td>
                <td>
                    {{ $payment->created_at->format('F j, Y') }}
                </td>
            </tr>
        </table>
    </div>
 
    <div class="footer margin-top">
        <div>Thank you</div>
        <div>This is a computer-generated receipt. No signature required.</div>
        <div>&copy; Apartment System</div>
    </div>
</body>
</html>
