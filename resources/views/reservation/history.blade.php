<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reservation History
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($pastRentals->isEmpty())
                    <p>No past reservations found.</p>
                @else
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Car</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Start Date</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">End Date</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Total Price</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastRentals as $rental)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $rental->car->brand }} {{ $rental->car->model }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $rental->start_date->format('Y-m-d') }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $rental->end_date->format('Y-m-d') }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">€{{ number_format($rental->total_price, 2) }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ ucfirst($rental->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
