<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Car Details
        </h2>
    </x-slot>

    @php
        $imageMap = [
             '01-AC-01' => 'day-exterior-4.png',
            'RS-39-SC' => '31703983-d100-46bf-8c30-679f21181232.jpg',
            'MS-BA-02' => '2020-toyota-yaris_vermelho.jpg',
            '09-TO-PE' => '1690370994_yaris-azul.png',
            '07-SE-AL' => 'ford focus branco.jpg',
            'AD-CT-09' => '2019-toyota-rav4-hybrid-review_preto.webp',
            'AB-10-RN' => '2025_honda_civic_sedan_si_fq_oem_1_1600.avif',
            'YG-FC-08' => 'honda-civic-2019-732x488_azul.webp',
            'GB-78-AH' => 'fl_progressive,f_webp,q_70,w_600.webp',
            'EH-16-PA' => 'images.jpg',
            'WS-54-RJ' => 'honda hrv preto.jpg',
            'SP-24-PB' => 'Touring_prata_platinum_0_0 honda hrv cinza.webp',
            'JV-95-HP' => 'ford focus branco.jpg',
            'PM-BP-90' => 'ford-focus-ford-focus-1-5-ecoblue-st-line-x-edition-s-s-5dr_8265219035.jpg',
            'PA-12-AP' => 'djnd.jpg',
            'MT-64-MG' => 'hq720.jpg',
            'AA-A1-03' => 'ford-ecosport-se-2021-1024x583.jpg.webp',
            'HY-10-27' => 'ford-ecosport-active.jpg',
            'DF-83-03' => 'volkswagen-golf-2017-2020-1701966027.9030082 VW golf cinza.jpg',
            'MA-PA-27' => 'vw-golf-gte.png',
            'AM-10-31' => 'vw polo vermelho.jpg',
            'CE-93-RO' => 'main_webp_comprar-polo-track-2025_6b295537a8.png.webp',
            'AC-RM-33' => '2021-VW-Tiguan-21 azul.jpg',
            '12-PM-36' => 'maxresdefault vw preto.jpg',
            'AC-MS-90' => 'Renault-CLIO-TCe-90-Bi-Fuel-6.jpg',
            'PR-59-23' => 'images (2).jpg',
            '21-ES-34' => 'Novo-Renault-Captur07.jpg',
            'BA-93-57' => 'Novo-Renault-Captur05.jpg',
            'GO-AL-68' => 'renault-megane-sw.png',
            '29-SE-97' => 'renault-megane-e-tech-2022-2025-1729833339.3727322.jpg',
            // Add all license plates with corresponding image filenames here
        ];
        $key = $car->license_plate;
        $imageFile = $imageMap[$key] ?? 'images.jpg';
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="w-full block bg-black hover:bg-gray-800 text-white font-semibold py-4 px-6 rounded">
                    <div class="mb-2">
                        <img src="{{ asset('images/' . $imageFile) }}"
                            alt="{{ $car->brand }} {{ $car->model }}" class="rounded w-full mb-2">
                    </div>
                    <h3 class="text-lg font-bold underline">
                        {{ $car->brand }} {{ $car->model }}
                    </h3>
                    <p>License Plate: {{ $car->license_plate }}</p>
                    <p>Price per Day: €{{ number_format($car->price_per_day, 2) }}</p>
                    <p>Status:
                        @if ($car->is_available)
                            <span class="text-yellow-800">Available</span>
                        @else
                            <span class="text-red-400">Not Available</span>
                        @endif
                    </p>
                    <p>Locations:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($car->localizacoes as $localizacao)
                            <li>{{ $localizacao->cidade }} - {{ $localizacao->filial }} - {{ $localizacao->posicao }}</li>
                        @endforeach
                    </ul>
                    <button onclick="document.getElementById('characteristics').classList.toggle('hidden')" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Characteristics
                    </button>
                    <div id="characteristics" class="hidden mt-2 bg-gray-100 text-black p-2 rounded">
                        @if($characteristics)
                            <p><strong>Brand:</strong> {{ $characteristics['marca']->nome }}</p>
                            <p><strong>Observation:</strong> {{ $characteristics['marca']->observacao }}</p>
                            <p><strong>Rentable Assets:</strong></p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($characteristics['bens_locaveis'] as $bem)
                                    <li>
                                        Model: {{ $bem->modelo }}, Color: {{ $bem->cor }}, Passengers: {{ $bem->numero_passageiros }}, Fuel: {{ $bem->combustivel }}, Doors: {{ $bem->numero_portas }}, Transmission: {{ $bem->transmissao }}, Year: {{ $bem->ano }}, Daily Price: €{{ number_format($bem->preco_diario, 2) }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No characteristics available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
