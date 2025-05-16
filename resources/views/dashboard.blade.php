<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
                        <label for="pickup" class="text-lg font-medium text-gray-700">Local de levantamento da
                            reserva:</label>
                        <input type="text" id="pickup" name="pickup" required
                            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 text-white font-medium text-base md:text-lg rounded-full px-8 py-3 shadow-md hover:shadow-lg transition duration-300">
                            Enviar confirmação por e-mail
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
