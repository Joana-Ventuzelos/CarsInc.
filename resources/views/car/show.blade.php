{{-- filepath: resources/views/car/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">All Cars ({{ $cars->total() }})</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($cars as $car)
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4 flex flex-col items-center">
                @if($car->image_path)
                    <img src="{{ asset('storage/' . $car->image_path) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-40 object-cover rounded mb-2">
                @else
                    <img src="https://via.placeholder.com/300x160?text=No+Image" alt="No Image" class="w-full h-40 object-cover rounded mb-2">
                @endif
                <div class="text-center">
                    <a href="{{ route('car.show', $car->id) }}" class="text-lg font-bold text-blue-600 hover:underline">
                        {{ $car->brand }} {{ $car->model }}
                    </a>
                    <p>License Plate: {{ $car->license_plate }}</p>
                    <p>Price per Day: ${{ number_format($car->price_per_day, 2) }}</p>
                    <p>Status:
                        @if($car->is_available)
                            <span class="text-green-500">Available</span>
                        @else
                            <span class="text-red-500">Not Available</span>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $cars->links() }}
    </div>
</div>
@endsection
