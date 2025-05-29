<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fatura Proforma - Aluguer de Carro</title>
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
        <h1>Fatura Proforma</h1>
        <h2>Aluguer de Viatura</h2>
        <p><strong>Nº:</strong> #PF-2025-001</p>
    </div>

    <div class="client-info">
        <strong>Cliente:</strong><br>
        João da Silva<br>
        Rua das Flores, 123<br>
        1000-000 Lisboa, Portugal
    </div>

    <div class="invoice-info">
        <strong>Data de Emissão:</strong> {{ now()->format('d/m/Y') }}<br>
        <strong>Período de Aluguer:</strong> {{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}<br>
        <strong>Dias Totais:</strong> {{ \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1 }} dias
    </div>

    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Aluguer de veículo - {{ $rental->car->brand }} {{ $rental->car->model }} ({{ $rental->car->engine }})</td>
                <td>{{ \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1 }} dias</td>
                <td>R$ {{ number_format($rental->car->price_per_day, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($rental->total_price, 2, ',', '.') }}</td>
            </tr>
            {{-- Add more rows here if there are additional reservation details --}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total Geral:</td>
                <td>R$ {{ number_format($rental->total_price, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="notes">
        <strong>Observações:</strong><br>
        Esta fatura proforma é válida por 5 dias. O valor apresentado está sujeito à disponibilidade do veículo na data da reserva.
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('processTransaction', ['car_id' => $rental->car->id, 'days' => \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1]) }}"
           style="display: inline-block; padding: 10px 20px; background-color: #0070ba; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Proceed with PayPal
        </a>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "{{ route('processTransaction', ['car_id' => $rental->car->id, 'days' => \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1]) }}";
        }, 10000); // 10 seconds delay
    </script>
</body>
</html>
