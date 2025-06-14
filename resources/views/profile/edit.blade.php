<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-4">
                <a href="{{ url('/dashboard') }}" class="inline-block px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition">
                    Go to CarsInc.
                </a>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl flex space-x-4">
                    @if(Auth::user()->email === 'admin@example.com')
                    <a href="{{ url('/users') }}" class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition">
                        Users
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
