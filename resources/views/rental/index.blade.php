<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Rentals
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($rentals->isEmpty())
                    <p>No rentals available.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($rentals as $rental)
                            <div class="flex flex-col space-y-2">
                                <a href="{{ route('rental.show', $rental->id) }}" class="w-full block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded text-center">
                                    {{ $rental->car->brand ?? 'Unknown' }} {{ $rental->car->model ?? '' }} - ${{ number_format($rental->total_price, 2) }}
                                </a>
                                <a href="{{ route('payment.create', ['rental_id' => $rental->id]) }}" class="w-full block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded text-center">
                                    Pay Now
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
