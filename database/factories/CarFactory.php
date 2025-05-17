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
     * Static array of example cars from bens_locaveis.
     *
     * @var array<int, array<string, mixed>>
     */
    public static array $examples = [
        ['brand' => 'Toyota', 'model' => 'Corolla', 'license_plate' => '01-AC-01', 'price_per_day' => 50.00, 'is_available' => true],
        ['brand' => 'Toyota', 'model' => 'Corolla', 'license_plate' => 'RS-39-SC', 'price_per_day' => 55.00, 'is_available' => true],
        ['brand' => 'Toyota', 'model' => 'Yaris', 'license_plate' => 'MS-BA-02', 'price_per_day' => 48.00, 'is_available' => true],
        ['brand' => 'Toyota', 'model' => 'Yaris', 'license_plate' => '09-TO-PE', 'price_per_day' => 50.00, 'is_available' => true],
        ['brand' => 'Toyota', 'model' => 'RAV4', 'license_plate' => '07-SE-AL', 'price_per_day' => 65.00, 'is_available' => true],
        ['brand' => 'Toyota', 'model' => 'RAV4', 'license_plate' => 'AD-CT-09', 'price_per_day' => 70.00, 'is_available' => true],
        ['brand' => 'Honda', 'model' => 'Civic', 'license_plate' => 'AB-10-RN', 'price_per_day' => 55.00, 'is_available' => true],
        ['brand' => 'Honda', 'model' => 'Civic', 'license_plate' => 'YG-FC-08', 'price_per_day' => 60.00, 'is_available' => true],
        ['brand' => 'Honda', 'model' => 'Fit', 'license_plate' => 'GB-78-AH', 'price_per_day' => 50.00, 'is_available' => true],
        ['brand' => 'Honda', 'model' => 'Fit', 'license_plate' => 'EH-16-PA', 'price_per_day' => 54.00, 'is_available' => true],
        ['brand' => 'Honda', 'model' => 'HR-V', 'license_plate' => 'WS-54-RJ', 'price_per_day' => 65.00, 'is_available' => true],
        ['brand' => 'Honda', 'model' => 'HR-V', 'license_plate' => 'SP-24-PB', 'price_per_day' => 70.00, 'is_available' => true],
        ['brand' => 'Ford', 'model' => 'Focus', 'license_plate' => 'JV-95-HP', 'price_per_day' => 55.00, 'is_available' => true],
        ['brand' => 'Ford', 'model' => 'Focus', 'license_plate' => 'PM-BP-90', 'price_per_day' => 59.00, 'is_available' => true],
        ['brand' => 'Ford', 'model' => 'Fiesta', 'license_plate' => 'PA-12-AP', 'price_per_day' => 48.00, 'is_available' => true],
        ['brand' => 'Ford', 'model' => 'Fiesta', 'license_plate' => 'MT-64-MG', 'price_per_day' => 52.00, 'is_available' => true],
        ['brand' => 'Ford', 'model' => 'EcoSport', 'license_plate' => 'AA-A1-03', 'price_per_day' => 60.00, 'is_available' => true],
        ['brand' => 'Ford', 'model' => 'EcoSport', 'license_plate' => 'HY-10-27', 'price_per_day' => 66.00, 'is_available' => true],
        ['brand' => 'Volkswagen', 'model' => 'Golf', 'license_plate' => 'DF-83-03', 'price_per_day' => 70.00, 'is_available' => true],
        ['brand' => 'Volkswagen', 'model' => 'Golf', 'license_plate' => 'MA-PA-27', 'price_per_day' => 75.00, 'is_available' => true],
        ['brand' => 'Volkswagen', 'model' => 'Polo', 'license_plate' => 'AM-10-31', 'price_per_day' => 58.00, 'is_available' => true],
        ['brand' => 'Volkswagen', 'model' => 'Polo', 'license_plate' => 'CE-93-RO', 'price_per_day' => 62.00, 'is_available' => true],
        ['brand' => 'Volkswagen', 'model' => 'Tiguan', 'license_plate' => 'AC-RM-33', 'price_per_day' => 80.00, 'is_available' => true],
        ['brand' => 'Volkswagen', 'model' => 'Tiguan', 'license_plate' => '12-PM-36', 'price_per_day' => 85.00, 'is_available' => true],
        ['brand' => 'Renault', 'model' => 'Clio', 'license_plate' => 'AC-MS-90', 'price_per_day' => 45.00, 'is_available' => true],
        ['brand' => 'Renault', 'model' => 'Clio', 'license_plate' => 'PR-59-23', 'price_per_day' => 47.00, 'is_available' => true],
        ['brand' => 'Renault', 'model' => 'Captur', 'license_plate' => '21-ES-34', 'price_per_day' => 60.00, 'is_available' => true],
        ['brand' => 'Renault', 'model' => 'Captur', 'license_plate' => 'BA-93-57', 'price_per_day' => 63.00, 'is_available' => true],
        ['brand' => 'Renault', 'model' => 'Megane', 'license_plate' => 'GO-AL-68', 'price_per_day' => 68.00, 'is_available' => true],
        ['brand' => 'Renault', 'model' => 'Megane', 'license_plate' => '29-SE-97', 'price_per_day' => 73.00, 'is_available' => true],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;
        $example = self::$examples[$index % count(self::$examples)];
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
