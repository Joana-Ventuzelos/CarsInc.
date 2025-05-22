<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CarsInc.') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-image: url('https://www.cargini.rent/data/public/rotator/cargini-homepage.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}
            </div>
            <div class="max-w-sm mx-auto p-5">
                @if (session('success'))
                    <div
                        class="alert alert-success shadow-lg rounded-lg py-4 px-6 font-semibold text-green-800 bg-green-100 ring-1 ring-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('send.email') }}" method="POST"
                    class="mt-5 flex flex-col items-center space-y-2 p-2 border-2 border-gray-500 rounded-lg shadow-lg bg-gray-100">
                    @csrf
                    <label for="pickup" class="text-lg font-medium text-gray-700">Reservation pickup location:</label>
                    <input type="text" id="pickup" name="pickup" required
                        class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition">
                        Send confirmation by email
                    </button>
                </form>
            </div>
            <div class="max-w-sm mx-auto p-5 mt-6 flex justify-around space-x-4">
                <a href="{{ route('car.index') }}" class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition">
                    Cars
                </a>
                <a href="{{ route('rental.index') }}" class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition">
                    Rentals
                </a>
                <a href="{{ url('/users') }}" class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition">
                    Users
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
