<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proforma Invoice - Car Rental</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1, h2 { margin-bottom: 5px; }
        .invoice-header { margin-bottom: 30px; }
        .client-info, .invoice-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .total { text-align: right; font-weight: bold; }
        .notes { margin-top: 30px; }
    </style>
</head>
<body>

    <div class="invoice-header">
        <h1>Proforma Invoice</h1>
        <h2>Car Rental</h2>
        <p><strong>No.:</strong> #PF-2025-001</p>
    </div>

    <div class="client-info">
        <strong>Client:</strong><br>
        João da Silva<br>
        Rua das Flores, 123<br>
        1000-000 Lisbon, Portugal
    </div>

    <div class="invoice-info">
        <strong>Issue Date:</strong> {{ now()->format('d/m/Y') }}<br>
        <strong>Rental Period:</strong> {{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}<br>
        <strong>Total Days:</strong> {{ \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1 }} days
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Vehicle Rental - {{ $rental->car->brand }} {{ $rental->car->model }} ({{ $rental->car->engine }})</td>
                <td>{{ \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1 }} days</td>
                <td>€ {{ number_format($rental->car->price_per_day, 2, ',', '.') }}</td>
                <td>€ {{ number_format($rental->total_price, 2, ',', '.') }}</td>
            </tr>
            {{-- Add more rows here if there are additional reservation details --}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Grand Total:</td>
                <td>€ {{ number_format($rental->total_price, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="notes">
        <strong>Notes:</strong><br>
        This proforma invoice is valid for 5 days. The amount shown is subject to vehicle availability on the reservation date.
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('processTransaction', ['car_id' => $rental->car->id, 'days' => \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1]) }}"
           style="display: inline-block; padding: 10px 20px; background-color: #0070ba; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Proceed with ATM
        </a>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "{{ route('processTransaction', ['car_id' => $rental->car->id, 'days' => \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1]) }}";
        }, 10000); // 10 seconds delay
    </script>
</body>
</html>
