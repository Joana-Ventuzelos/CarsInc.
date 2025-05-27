<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Checkout - Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md text-center">

        <h2 class="text-2xl font-bold mb-4">Iniciar Pagamento com PayPal</h2>

        {{-- Mensagens de Sucesso / Erro --}}
        @if (session('success'))
            <div class="p-4 mb-4 text-white bg-green-500 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-white bg-red-500 rounded-md">
                {{ session('error') }}
            </div>
        @endif

    {{--    <x-card-payment buttonText="Pagar Agora com PayPal" method="GET" />--}}
           <section class="flex items-center justify-center mt-10 pb-10">
            <div class="p-2 sm:px-10 flex flex-col justify-center items-center text-base h-100vh mx-auto"
                id="pricing">
                <div class="isolate mx-auto grid max-w-md grid-cols-1 gap-2 lg:mx-0 lg:max-w-none">
                    <div class="ring-2 ring-blue-600 rounded-3xl p-4 xl:p-10">
                        <div class="flex items-center justify-between gap-x-4">
                            <h3 id="tier-extended" class="text-blue-600 text-2xl font-semibold leading-8">Comprar</h3>
                            <p
                                class="rounded-full bg-blue-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-blue-600">
                                Mais popular</p>
                        </div>
                        <p class="mt-4 text-base leading-6 text-gray-600">Pagar com Cartão de teste oferecido pelo PayPal</p>
                        <p class="mt-6 flex items-center justify-center mb-4 text-center">
                            <span class="line-through text-2xl font-sans text-gray-500/70">10€</span>
                            <span class="text-5xl font-bold tracking-tight text-gray-900">1€</span>
                        </p>
                        <form action="{{ route('processTransaction') }}" method="GET">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Pagar com PayPal
                            </button>
                        </form>
                        <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10">
                            <li class="flex gap-x-3 text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    class="h-6 w-5 flex-none text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>Pagamento seguro
                            </li>
                            <li class="flex gap-x-3 text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    class="h-6 w-5 flex-none text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>Pagamento único
                            </li>
                            <li class="flex gap-x-3 text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    class="h-6 w-5 flex-none text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>Pagamento simples
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </div>
</body>

</html>


<!-- SDK do PayPal com sua Client ID e moeda EUR -->
<script
    src="https://www.sandbox.paypal.com/sdk/js?client-id={{ config('paypal.sandbox.client_id') }}&currency=EUR&intent=capture">
</script>
