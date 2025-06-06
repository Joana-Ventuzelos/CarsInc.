<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Confirmation') }}
        </h2>
    </x-slot>
    @if (session('Success'))
        <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
            {{ session('Success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-200 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white shadow-sm rounded-lg p-6">
            <form method="POST" action="{{ route('send.confirmation.email', ['car_id' => request('car_id')]) }}" >
                @csrf
                <div class="mb-4">
                    <label for="client_name" class="block font-semibold mb-2">E-mail</label>
                    <input type="text" id="client_name" name="client_name" class="w-full border rounded px-3 py-2"
                        required>
                </div>

                <div class="mb-4">
                    <p>Do you want to send the confirmation by email?</p>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Send Confirmation by Email
                    </button>
                </form>
                    <a href="{{ route('reservation.history') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 flex items-center justify-center">
                        Skip and Go to Reservation History
                    </a>
                    <a href="{{ route('reservation.pdf', ['car_id' => request('car_id'), 'days' => request('days')]) }}"
                        target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Download PDF
                    </a>
                </div>
        </div>
    </div>
</x-app-layout>
