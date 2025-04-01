<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchases Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            direction: ltr; /* Left-to-right for English */
            text-align: left;
        }

        .header {
            text-align: center;
            background-color: #f4f4f4;
            padding: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .report-details {
            margin: 10px 0 20px 0;
            text-align: left;
        }

        .report-details span {
            display: block;
            font-size: 14px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        table td {
            padding: 10px;
            text-align: center;
            font-size: 12px;
            border: 1px solid #ddd;
        }

        table .highlight {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .total-row {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Purchases Report</h1>
        <p>Period: From {{ $Start_time }} to {{ $End_time }}</p>
    </div>

    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Selling Price</th>
                    <th>Buying Price</th>
                    <th>Total Profit</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                    <tr>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->counter }}</td>
                        <td>{{ number_format($i->price_sales, 2) }}</td>
                        <td>{{ number_format($i->price_buy, 2) }}</td>
                        <td>{{ number_format($i->Balance, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($i->created_at)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4">Total Profit</td>
                    <td colspan="2">{{ number_format($total_Balance, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
