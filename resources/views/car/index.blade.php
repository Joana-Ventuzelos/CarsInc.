<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cars ({{ $cars->total() }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($cars->isEmpty())
                    <p>No cars available.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($cars as $car)
                            <div class="w-full block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded">
                                {{-- Placeholder for car image --}}
                                <div class="mb-2">
                                    <img src="https://via.placeholder.com/150x80?text=Car+Image" alt="Car Image" class="rounded w-full mb-2">
                                </div>
                                <a href="{{ route('car.show', $car->id) }}" class="text-lg font-bold underline">
                                    {{ $car->brand }} {{ $car->model }}
                                </a>
                                <p>License Plate: {{ $car->license_plate }}</p>
                                <p>Price per Day: ${{ number_format($car->price_per_day, 2) }}</p>
                                <p>Status:
                                    @if($car->is_available)
                                        <span class="text-green-400">Available</span>
                                    @else
                                        <span class="text-red-400">Not Available</span>
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $cars->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
