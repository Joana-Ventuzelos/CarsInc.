@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reservation Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .section {
            margin-top: 20px;
        }
        .section h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .total {
            font-weight: bold;
            font-size: 1.1em;
            text-align: right;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h1>Reservation Confirmation</h1>

    <div class="section">
        <h2>Client Information</h2>
        <p><strong>Name:</strong> {{ $clientName ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $clientEmail ?? 'N/A' }}</p>
    </div>

    <div class="section">
        <h2>Reservation Details</h2>
        <table>
            <thead>
                <tr>
                    <th>User Type</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Features</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Price (€)</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $userType }}</td>
                    <td>{{ $car->brand ?? 'N/A' }}</td>
                    <td>{{ $car->model ?? 'N/A' }}</td>
                    <td>
                        @if($features && count($features) > 0)
                            @foreach($features as $feature)
                                <span>{{ $feature->name ?? $feature->nome ?? 'N/A' }}</span>@if(!$loop->last), @endif
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $startDate ?? 'N/A' }}</td>
                    <td>{{ $endDate ?? 'N/A' }}</td>
                    <td>{{ number_format($rental->total_price ?? 0, 2) }}</td>
                    <td>{{ $paymentMethod }}</td>
                    <td>
                        @if(($status ?? 'Confirmed') === 'Confirmed' || ($status ?? '') === 'Pending')
                            <span>Confirmed</span>
                        @else
                            {{ $status ?? 'Confirmed' }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
