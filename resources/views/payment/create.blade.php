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

                    @foreach ($rental_ids as $index => $rentalId)
                        <input type="hidden" name="rental_ids[]" value="{{ $rentalId }}" />
                        <input type="hidden" name="amounts[]" value="{{ \App\Models\Rental::find($rentalId)->total_price }}" />
                    @endforeach

                    <div class="mb-4">
                        <label for="rental_days" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Rental Days</label>
                        <input id="rental_days" name="rental_days" type="number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Payment Method</label>
                        <select id="payment_method" name="payment_method" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select a method</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>

                    <div id="paypal-button-container" class="mb-4" style="display:none;"></div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Amounts per Car</label>
                        <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 mb-2">
                            @foreach ($rental_ids as $rentalId)
                                @php
                                    $rental = \App\Models\Rental::find($rentalId);
                                @endphp
                                <li>
                                    Car: {{ $rental->car->brand }} {{ $rental->car->model }} - Amount: €{{ number_format($rental->total_price, 2) }}
                                </li>
                            @endforeach
                        </ul>
                        <p class="text-lg font-semibold">Total: €{{ number_format($amount ?? 0, 2) }}</p>
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
                        <button type="submit" id="submit-button"
                            class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition">
                            Pay Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethodSelect = document.getElementById('payment_method');
        const paypalButtonContainer = document.getElementById('paypal-button-container');
        const submitButton = document.getElementById('submit-button');
        const form = document.getElementById('payment-form') || document.querySelector('form');

        function togglePayPalButton() {
            if (paymentMethodSelect.value === 'paypal') {
                paypalButtonContainer.style.display = 'block';
                submitButton.style.display = 'none';
            } else {
                paypalButtonContainer.style.display = 'none';
                submitButton.style.display = 'inline-block';
            }
        }

        paymentMethodSelect.addEventListener('change', togglePayPalButton);

        togglePayPalButton();

        paypal.Buttons({
            createOrder: function (data, actions) {
                const totalAmount = parseFloat(document.querySelector('p.text-lg').textContent.replace('Total: €', '')) || 0;

                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: totalAmount.toFixed(2)
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    const hiddenInputPaymentId = document.createElement('input');
                    hiddenInputPaymentId.type = 'hidden';
                    hiddenInputPaymentId.name = 'paymentId';
                    hiddenInputPaymentId.value = data.orderID;

                    const hiddenInputPayerID = document.createElement('input');
                    hiddenInputPayerID.type = 'hidden';
                    hiddenInputPayerID.name = 'PayerID';
                    hiddenInputPayerID.value = details.payer.payer_id;

                    form.appendChild(hiddenInputPaymentId);
                    form.appendChild(hiddenInputPayerID);

                    form.submit();
                });
            }
        }).render('#paypal-button-container');
    });
</script>
</x-app-layout>
