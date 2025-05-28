<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cars ({{ $cars->total() }})
        </h2>
    </x-slot>

    @php
        $imageMap = [
            '01-AC-01' => 'day-exterior-4.png',
            'RS-39-SC' => '31703983-d100-46bf-8c30-679f21181232.jpg',
            'MS-BA-02' => '2020-toyota-yaris_vermelho.jpg',
            '09-TO-PE' => '1690370994_yaris-azul.png',
            '07-SE-AL' => '2019-toyota-rav4-hybrid-review_preto.webp',
            'AD-CT-09' => 'images (1).jpg',
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
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('car.index') }}" class="mb-4 flex flex-wrap items-center space-x-2">
                    <input type="text" name="brand" value="{{ request('brand') }}" placeholder="Brand" class="border rounded py-2 px-3 mr-2">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price" class="border rounded py-2 px-3 mr-2" min="0" step="0.01">
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" class="border rounded py-2 px-3 mr-2" min="0" step="0.01">
                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">Search</button>
                    <a href="{{ route('rental.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded ml-2">Rental</a>
                </form>
                @if ($cars->isEmpty())
                    <p>No cars available.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($cars as $car)
                            @php
                                $key = $car->license_plate;
                                $imageFile = $imageMap[$key] ?? 'images.jpg';
                            @endphp
                            <div
                                class="w-full block bg-black hover:bg-gray-800 text-white font-semibold py-4 px-6 rounded">
                                <div class="mb-2">
                                    <img src="{{ asset('images/' . $imageFile) }}"
                                        alt="{{ $car->brand }} {{ $car->model }}" class="rounded w-full mb-2">
                                </div>
                                <a href="{{ route('car.show', $car->id) }}" class="text-lg font-bold underline">
                                    {{ $car->brand }} {{ $car->model }}
                                </a>
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
                                <button onclick="document.getElementById('characteristics-{{ $car->id }}').classList.toggle('hidden')" class="mt-2 bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
                                    Characteristics
                                </button>
                                <div id="characteristics-{{ $car->id }}" class="hidden mt-2 bg-gray-100 text-black p-2 rounded">
                                    @if(isset($characteristics[$car->id]) && $characteristics[$car->id])
                                        <p><strong>Brand:</strong> {{ $characteristics[$car->id]['marca']->nome }}</p>
                                        <p><strong>License Plate:</strong> {{ $car->license_plate }}</p>
                                        <p><strong>Observation:</strong> {{ $characteristics[$car->id]['marca']->observacao }}</p>
                                        <p><strong>Rentable Assets:</strong></p>
                                        @php
                                            $bensLocaveisForCar = $characteristics[$car->id]['bens_locaveis']->filter(function($bem) use ($car) {
                                                return isset($bem->marca)
                                                    && $bem->marca->nome === $car->brand
                                                    && (
                                                        (isset($bem->registo_unico_publico) && $bem->registo_unico_publico === $car->license_plate)
                                                        || (isset($bem->license_plate) && $bem->license_plate === $car->license_plate)
                                                    );
                                            });
                                        @endphp
                                        @if($bensLocaveisForCar->count())
                                            <ul class="list-disc list-inside text-sm">
                                                @foreach ($bensLocaveisForCar as $bem)
                                                    <li>
                                                        <strong>Brand:</strong> {{ $bem->marca->nome ?? '-' }},
                                                        <strong>Model:</strong> {{ $bem->modelo }},
                                                        <strong>Color:</strong> {{ $bem->cor }},
                                                        <strong>License Plate:</strong> {{ $bem->registo_unico_publico ?? $bem->license_plate }},
                                                        <strong>Passengers:</strong> {{ $bem->numero_passageiros }},
                                                        <strong>Fuel:</strong> {{ $bem->combustivel }},
                                                        <strong>Doors:</strong> {{ $bem->numero_portas }},
                                                        <strong>Transmission:</strong> {{ $bem->transmissao }},
                                                        <strong>Year:</strong> {{ $bem->ano }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-sm text-gray-500">No rentable assets for this car.</p>
                                        @endif
                                    @else
                                        <p>No characteristics available.</p>
                                    @endif
                                </div>
                                <!-- Removed individual reservar buttons as requested -->
                                <!-- Removed individual reservar buttons as requested -->
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $cars->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
