<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Checkout - Laravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md text-center">

        @if (session('success'))
            <div class="p-4 mb-4 text-white bg-green-500 rounded-md">
                {{ session('success') }}
            </div>
        @endif


        <div class="bg-gray-100 p-6 rounded-md shadow-sm max-w-lg mx-auto">
            <h2 class="text-2xl font-bold mb-4 text-center">Transação Finalizada com Sucesso</h2>

            @if (isset($amount) && isset($payerName))
                <div class="p-4 mb-4 text-white bg-green-500 rounded-md text-center">
                    <p class="text-lg font-semibold">Pagamento Realizado!</p>
                    <p class="text-sm">Valor: <span class="font-bold">{{ $amount }}</span>, pago por: <span
                            class="font-bold">{{ $payerName }}</span>.</p>
                </div>
            @endif

            {{-- Botão para voltar à página inicial ou continuar navegando --}}
            <div class="flex justify-center">
                <a href="{{ route('createTransaction') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 text-center">
                    Fazer nova transação
                </a>
            </div>
        </div>

    </div>
</body>

</html>
