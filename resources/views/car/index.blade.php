<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cars ({{ $cars->total() }})
        </h2>
    </x-slot>

    @php
        $imageMap = [
            'toyota-corolla' => 'images.jpg',
            'toyota-yaris' => 'toyota-yaris-front-angle-low-view-981954.avif',
            'toyota-rav4' => 'images (1).jpg',
            'honda-civic' => '2025_honda_civic_sedan_si_fq_oem_1_1600.avif',
            'honda-fit' => 'fl_progressive,f_webp,q_70,w_600.webp',
            'honda-hr-v' => '2025-Honda-HR-V-facelift-2-e1731296545661-1260x710.jpg',
            'ford-focus' => 'ford-focus-eu-Column_Card_Focus-ST-3x2-1000x667-mean-green-front-view.jpg',
            'ford-fiesta' => 'hq720.jpg',
            'ford-ecosport' => 'Agate Black Metallic-UM-18,18,20-640-en_US.avif',
            'volkswagen-golf' => 'Volkswagen-Golf-2025-picture-10.webp',
            'volkswagen-polo' => 'main_webp_comprar-polo-track-2025_6b295537a8.png.webp',
            'volkswagen-tiguan' => 'Volkswagen-Tiguan-2024-06.webp',
            'renault-clio' => 'renault-clio-2023-2025-1729678356.6909268.jpg',
            'renault-captur' => 'e5368ff9-75ac-4bc1-9943-75d25ba8113b.jpg',
            'renault-megane' => 'renault-megane-e-tech-2022-2025-1729833339.3727322.jpg',
        ];
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($cars->isEmpty())
                    <p>No cars available.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($cars as $car)
                            @php
                                $key = strtolower(str_replace(' ', '-', $car->brand)) . '-' . strtolower(str_replace(' ', '-', $car->model));
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
