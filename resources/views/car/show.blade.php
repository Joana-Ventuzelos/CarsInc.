<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold">{{ $car->brand }} {{ $car->model }}</h1>
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
        $key = strtolower(str_replace(' ', '-', $car->brand)) . '-' . strtolower(str_replace(' ', '-', $car->model));
        $imageFile = $imageMap[$key] ?? 'images.jpg';
    @endphp

    <div class="container mx-auto p-4">
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 flex flex-col items-center">
            <img src="{{ asset('images/' . $imageFile) }}"
                alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-60 object-cover rounded mb-4">
            <div class="text-center">
                <p>License Plate: {{ $car->license_plate }}</p>
                <p>Price per Day: ${{ number_format($car->price_per_day, 2) }}</p>
                <p>Status:
                    @if($car->is_available)
                        <span class="text-green-500">Available</span>
                    @else
                        <span class="text-red-500">Not Available</span>
                    @endif
                </p>
                <p>Characteristics:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach($car->caracteristicas as $caracteristica)
                        <li>{{ $caracteristica->nome }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
