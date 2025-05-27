<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Rental & Pay with PayPal
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('rental.storeAndRedirect') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="car_id" class="block font-bold mb-2">Choose Car</label>
                        <select name="car_id" id="car_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">Select a car</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}"
                                    data-price="{{ $car->price_per_day }}">
                                    {{ $car->brand }} {{ $car->model }} ({{ $car->license_plate }}) - €{{ number_format($car->price_per_day, 2) }}/day
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="days" class="block font-bold mb-2">Number of Days</label>
                        <input type="number" name="days" id="days" value="1" min="1"
                            class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Total Amount (€)</label>
                        <input type="text" id="amount" name="amount" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                    </div>

                    <button type="submit"
                        class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition w-full">
                        Proceed to PayPal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateAmount() {
            const carSelect = document.getElementById('car_id');
            const daysInput = document.getElementById('days');
            const amountInput = document.getElementById('amount');
            const selectedOption = carSelect.options[carSelect.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const days = parseInt(daysInput.value) || 1;
            amountInput.value = (price * days).toFixed(2);
        }
        document.getElementById('car_id').addEventListener('change', updateAmount);
        document.getElementById('days').addEventListener('input', updateAmount);
        window.onload = updateAmount;
    </script>
</x-app-layout>
