<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Rental ({{ $rentals->total() }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($cars->isEmpty())
                    <p>No rentals available.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($cars as $car)
<div class="w-full block bg-black hover:bg-gray-800 text-white font-semibold py-4 px-6 rounded">
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
    <span class="text-yellow-800">Available</span>
@else
    <span class="text-red-400">Not Available</span>
@endif
                                </p>
<div class="mt-4 flex flex-col justify-center space-y-2">
    @foreach($car->caracteristicas as $caracteristica)
        <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-0.5 px-2 rounded text-xs">
            {{ $caracteristica->nome }}
        </button>
    @endforeach
</div>
                            <div class="mt-4">
                                <a href="{{ route('payment.create', ['rental_id' => $car->id]) }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">
                                    Payment
                                </a>
                            </div>
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
