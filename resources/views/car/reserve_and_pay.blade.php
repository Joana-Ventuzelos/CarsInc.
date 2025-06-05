<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reserve a Car and Pay with ATM
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4">Please reserve your car and proceed to payment using Multibanco (ATM).</p>
                <a href="{{ route('rental.create') }}" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500 font-bold mr-4">
                    Reserve a Car
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
