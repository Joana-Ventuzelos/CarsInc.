<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CarsInc.') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <footer class="bg-gray-900 text-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div>
                    <h3 class="font-bold text-lg mb-2">Sobre Nós</h3>
                    <p class="text-sm max-w-xs">
                        Somos uma empresa dedicada ao aluguer de carros, oferecendo qualidade, segurança e atendimento personalizado para tornar sua experiência inesquecível.
                    </p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-2">Contactos</h3>
                    <ul class="text-sm">
                        <li>Email: <a href="mailto:info@cars20.pt" class="underline hover:text-yellow-400">info@cars20.pt</a></li>
                        <li>Telefone: <a href="tel:+351912345678" class="underline hover:text-yellow-400">+351 912 345 678</a></li>
                        <li>Rua: Rua das Viaturas, 123, 1000-000 Lisboa</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-2">Links Úteis</h3>
                    <ul class="text-sm">
                        <li><a href="{{ route('rental.index') }}" class="underline hover:text-yellow-400">Aluguer de Carros</a></li>
                        <li><a href="{{ route('reservation.history') }}" class="underline hover:text-yellow-400">Minhas Reservas</a></li>
                        <li><a href="#" class="underline hover:text-yellow-400">Termos &amp; Condições</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-xs text-gray-400 py-2 border-t border-gray-800 mt-4">
                &copy; {{ date('Y') }} Cars 2.0. Todos os direitos reservados a Joana Ventuzelos e um especial agradecimento ao Luís Mago, Ângela Peixoto e Rui Silva.
            </div>
        </footer>
    </body>
</html>
