<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Reservation History
        </h2>
    </x-slot>

    <div class="py-12 text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($pastRentals->isEmpty())
                    <p>No past reservations found.</p>
                @else
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">User Type</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Car</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Features</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Start Date</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">End Date</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Total Price</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Payment Method</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastRentals as $rental)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        {{ $userType }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        {{ optional($rental->car)->brand ?? 'N/A' }} {{ optional($rental->car)->model ?? '' }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        @if(optional($rental->car) && $rental->car->caracteristicas && $rental->car->caracteristicas->count())
                                            @foreach($rental->car->caracteristicas as $feature)
                                                <span class="inline-block bg-gray-200 dark:bg-gray-700 rounded px-2 py-1 text-xs font-semibold text-gray-700 dark:text-gray-300 mr-1">
                                                    {{ $feature->name ?? $feature->nome ?? 'N/A' }}
                                                </span>
                                            @endforeach
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        {{ $rental->start_date ? $rental->start_date->format('Y-m-d') : 'N/A' }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        {{ $rental->end_date ? $rental->end_date->format('Y-m-d') : 'N/A' }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        €{{ number_format($rental->total_price ?? 0, 2) }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        @if($rental->payments && $rental->payments->isNotEmpty())
                                            {{ ucfirst($rental->payments->first()->payment_method) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        {{ ucfirst($rental->status ?? 'N/A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
