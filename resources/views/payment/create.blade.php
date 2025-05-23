<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Make a Payment
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('payment.store') }}">
                    @csrf
                    <input type="hidden" name="rental_id" value="{{ request('rental_id') }}" />

                    @php
                        $rental = null;
                        $amount = 0;
                        if(request()->has('rental_id')) {
                            $rental = \App\Models\Rental::find(request('rental_id'));
                            $amount = $rental ? $rental->total_price : 0;
                        }
                    @endphp

                    <div class="mb-4">
                        <label for="rental_days" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Rental Days</label>
                        <input id="rental_days" name="rental_days" type="number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Amount</label>
                        <p class="text-lg font-semibold">€{{ number_format($amount, 2) }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Payment Method</label>
                        <select id="payment_method" name="payment_method" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select a method</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Description (optional)</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('reservation.history') }}"
                            class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">
                            Reservation History
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition">
                            Pay Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
