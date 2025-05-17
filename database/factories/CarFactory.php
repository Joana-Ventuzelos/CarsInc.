<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Car::class;

    /**
     * Static array of 20 example cars.
     *
     * @var array<int, array<string, mixed>>
     */
    public static array $examples = [
        ['brand' => 'Toyota', 'model' => 'Corolla', 'license_plate' => 'ABC-1234', 'price_per_day' => 50.00, 'is_available' => true],
        ['brand' => 'Honda', 'model' => 'Civic', 'license_plate' => 'DEF-5678', 'price_per_day' => 55.00, 'is_available' => true],
        ['brand' => 'Ford', 'model' => 'Focus', 'license_plate' => 'GHI-9012', 'price_per_day' => 45.00, 'is_available' => false],
        ['brand' => 'Chevrolet', 'model' => 'Malibu', 'license_plate' => 'JKL-3456', 'price_per_day' => 60.00, 'is_available' => true],
        ['brand' => 'Nissan', 'model' => 'Sentra', 'license_plate' => 'MNO-7890', 'price_per_day' => 48.00, 'is_available' => true],
        ['brand' => 'Volkswagen', 'model' => 'Jetta', 'license_plate' => 'PQR-2345', 'price_per_day' => 52.00, 'is_available' => false],
        ['brand' => 'Hyundai', 'model' => 'Elantra', 'license_plate' => 'STU-6789', 'price_per_day' => 47.00, 'is_available' => true],
        ['brand' => 'Kia', 'model' => 'Forte', 'license_plate' => 'VWX-0123', 'price_per_day' => 46.00, 'is_available' => true],
        ['brand' => 'Mazda', 'model' => '3', 'license_plate' => 'YZA-4567', 'price_per_day' => 49.00, 'is_available' => true],
        ['brand' => 'Subaru', 'model' => 'Impreza', 'license_plate' => 'BCD-8901', 'price_per_day' => 53.00, 'is_available' => false],
        ['brand' => 'Tesla', 'model' => 'Model 3', 'license_plate' => 'EFG-2345', 'price_per_day' => 120.00, 'is_available' => true],
        ['brand' => 'BMW', 'model' => '3 Series', 'license_plate' => 'HIJ-6789', 'price_per_day' => 110.00, 'is_available' => true],
        ['brand' => 'Mercedes-Benz', 'model' => 'C-Class', 'license_plate' => 'KLM-0123', 'price_per_day' => 115.00, 'is_available' => false],
        ['brand' => 'Audi', 'model' => 'A4', 'license_plate' => 'NOP-4567', 'price_per_day' => 108.00, 'is_available' => true],
        ['brand' => 'Lexus', 'model' => 'IS', 'license_plate' => 'QRS-8901', 'price_per_day' => 105.00, 'is_available' => true],
        ['brand' => 'Acura', 'model' => 'TLX', 'license_plate' => 'TUV-2345', 'price_per_day' => 102.00, 'is_available' => true],
        ['brand' => 'Infiniti', 'model' => 'Q50', 'license_plate' => 'WXY-6789', 'price_per_day' => 100.00, 'is_available' => false],
        ['brand' => 'Volvo', 'model' => 'S60', 'license_plate' => 'ZAB-0123', 'price_per_day' => 98.00, 'is_available' => true],
        ['brand' => 'Jaguar', 'model' => 'XE', 'license_plate' => 'CDE-4567', 'price_per_day' => 115.00, 'is_available' => true],
        ['brand' => 'Alfa Romeo', 'model' => 'Giulia', 'license_plate' => 'FGH-8901', 'price_per_day' => 112.00, 'is_available' => true],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => $this->faker->company(),
            'model' => $this->faker->word(),
            'license_plate' => strtoupper($this->faker->bothify('???-####')),
            'price_per_day' => $this->faker->randomFloat(2, 30, 200),
            'is_available' => $this->faker->boolean(80),
        ];
    }
}
