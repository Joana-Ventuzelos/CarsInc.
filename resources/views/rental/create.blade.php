<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Reserve Car and Pay with PayPal
        </h2>
    </x-slot>

    <div class="py-12 text-white">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('rental.storeAndRedirect') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="car_id" class="block font-bold mb-2">Choose Car</label>
                        <select name="car_id" id="car_id" class="w-full border rounded px-3 py-2 text-black" required>
                            <option value="">Select a car</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}"
                                    data-price="{{ $car->price_per_day }}"
                                    @if(request('car_id') == $car->id) selected @endif>
                                    {{ $car->brand }} {{ $car->model }} ({{ $car->license_plate }}) - €{{ number_format($car->price_per_day, 2) }}/day
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block font-bold mb-2">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="w-full border rounded px-3 py-2 text-black" value="{{ old('start_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block font-bold mb-2">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="w-full border rounded px-3 py-2 text-black" value="{{ old('end_date', date('Y-m-d', strtotime('+1 day'))) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="block font-bold mb-2">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="w-full border rounded px-3 py-2 text-black" required>
                            <option value="paypal" selected>ATM</option>
                        </select>
                    </div>

                    <input type="hidden" name="status" value="pending" />

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Total Amount (€)</label>
                        <input type="text" id="amount" name="amount" class="w-full border rounded px-3 py-2 bg-gray-100 text-black" readonly>
                    </div>

                    <button type="submit"
                        class="px-4 py-2 bg-yellow-700 text-black rounded hover:bg-yellow-800 transition w-full">
                        Proceed with ATM
                    </button>
                </form>
            </div>
            <div class="mb-4 flex justify-end">
            </div>
        </div>

        <script>
            function updateAmount() {
                const carSelect = document.getElementById('car_id');
                const startDateInput = document.getElementById('start_date');
                const endDateInput = document.getElementById('end_date');
                const amountInput = document.getElementById('amount');

                const selectedOption = carSelect.options[carSelect.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;

                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                let days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                if (days < 1) {
                    days = 1;
                }

                amountInput.value = (price * days).toFixed(2);
            }

            document.getElementById('car_id').addEventListener('change', updateAmount);
            document.getElementById('start_date').addEventListener('change', updateAmount);
            document.getElementById('end_date').addEventListener('change', updateAmount);

            window.onload = updateAmount;
        </script>
    </div>
</x-app-layout>
