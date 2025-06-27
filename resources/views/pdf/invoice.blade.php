<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SEA Catering Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #2e7d32;
        }

        .header p {
            font-size: 16px;
            margin-top: 8px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h3 {
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            color: #2c3e50;
        }

        .section p {
            margin: 4px 0;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            text-align: center;
            color: #777;
        }

        .highlight {
            color: #2e7d32;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>SEA Catering Invoice</h1>
        <p>Thank you for subscribing!<br>
            Your meal plan is active until
            <span class="highlight">
                {{ \Carbon\Carbon::parse(collect($subscription->delivery_days)->max())->format('d M Y') }}
            </span>.
        </p>
    </div>

    <div class="section">
        <h3>Customer Information</h3>
        <p><strong>Name:</strong> {{ $subscription->full_name }}</p>
        <p><strong>Phone:</strong> {{ $subscription->phone }}</p>
        <p><strong>Plan Selected:</strong> {{ ucwords(str_replace('_', ' ', $subscription->plan)) }}</p>
        <p><strong>Total Price:</strong> Rp{{ number_format($subscription->total_price, 0, ',', '.') }}</p>
    </div>

    <div class="section">
        <h3>Meal Types</h3>
        <ul>
            @foreach($subscription->meal_types as $meal)
                <li>{{ $meal }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <h3>Delivery Schedule</h3>
        <table>
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscription->delivery_days as $day)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($day)->format('l') }}</td>
                        <td>{{ \Carbon\Carbon::parse($day)->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($subscription->allergies)
        <div class="section">
            <h3>Allergy Info</h3>
            <p>{{ $subscription->allergies }}</p>
        </div>
    @endif

    <div class="footer">
        <p><em>Generated on {{ now()->format('d M Y H:i') }} | SEA Catering</em></p>
    </div>

</body>
</html>
