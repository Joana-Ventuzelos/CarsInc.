<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Confirmation</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Reservation Confirmation</h1>

        <form method="POST" action="{{ route('send.confirmation.email') }}">
            @csrf

            <div class="mb-4">
                <label for="client_name" class="block font-semibold mb-2">E-mail</label>
                <input type="text" id="client_name" name="client_name" class="w-full border rounded px-3 py-2" required>
            </div>

            <h2 class="text-xl font-semibold mb-4">Car Details</h2>
            @if(isset($car))
                <ul class="mb-6 list-disc list-inside">
                    <li><strong>Brand:</strong> {{ $car->brand }}</li>
                    <li><strong>Model:</strong> {{ $car->model }}</li>
                    <li><strong>License Plate:</strong> {{ $car->license_plate }}</li>
                    <li><strong>Price per Day:</strong> €{{ number_format($car->price_per_day, 2) }}</li>
                    @if($car->caracteristicas)
                        <li><strong>Characteristics:</strong>
                            <ul class="list-disc list-inside ml-5">
                                @foreach($car->caracteristicas as $caracteristica)
                                    <li>{{ $caracteristica->name }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            @else
                <p>No car details available.</p>
            @endif

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Confirm Reservation
            </button>
        </form>

        <div class="mt-6">
            <a href="{{ route('reservation.pdf', ['clientName' => $user->name]) }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Download Reservation PDF
            </a>
        </div>
    </div>
</body>
</html>
