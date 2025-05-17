<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Rental::class;

    /**
     * Static array of example rentals based on locacao_carros.sql data.
     *
     * @var array<int, array<string, mixed>>
     */
    public static array $examples = [
        ['user_id' => 1, 'car_id' => 1, 'start_date' => '2024-07-01', 'end_date' => '2024-07-05', 'total_price' => 200.00, 'status' => 'confirmed'],
        ['user_id' => 2, 'car_id' => 2, 'start_date' => '2024-07-02', 'end_date' => '2024-07-06', 'total_price' => 220.00, 'status' => 'pending'],
        ['user_id' => 3, 'car_id' => 3, 'start_date' => '2024-07-03', 'end_date' => '2024-07-07', 'total_price' => 180.00, 'status' => 'cancelled'],
        ['user_id' => 4, 'car_id' => 4, 'start_date' => '2024-07-04', 'end_date' => '2024-07-08', 'total_price' => 240.00, 'status' => 'confirmed'],
        ['user_id' => 5, 'car_id' => 5, 'start_date' => '2024-07-05', 'end_date' => '2024-07-09', 'total_price' => 190.00, 'status' => 'pending'],
        ['user_id' => 6, 'car_id' => 6, 'start_date' => '2024-07-06', 'end_date' => '2024-07-10', 'total_price' => 210.00, 'status' => 'confirmed'],
        ['user_id' => 7, 'car_id' => 7, 'start_date' => '2024-07-07', 'end_date' => '2024-07-11', 'total_price' => 230.00, 'status' => 'cancelled'],
        ['user_id' => 8, 'car_id' => 8, 'start_date' => '2024-07-08', 'end_date' => '2024-07-12', 'total_price' => 250.00, 'status' => 'confirmed'],
        ['user_id' => 9, 'car_id' => 9, 'start_date' => '2024-07-09', 'end_date' => '2024-07-13', 'total_price' => 195.00, 'status' => 'pending'],
        ['user_id' => 10, 'car_id' => 10, 'start_date' => '2024-07-10', 'end_date' => '2024-07-14', 'total_price' => 205.00, 'status' => 'confirmed'],
        ['user_id' => 11, 'car_id' => 11, 'start_date' => '2024-07-11', 'end_date' => '2024-07-15', 'total_price' => 300.00, 'status' => 'confirmed'],
        ['user_id' => 12, 'car_id' => 12, 'start_date' => '2024-07-12', 'end_date' => '2024-07-16', 'total_price' => 310.00, 'status' => 'pending'],
        ['user_id' => 13, 'car_id' => 13, 'start_date' => '2024-07-13', 'end_date' => '2024-07-17', 'total_price' => 320.00, 'status' => 'cancelled'],
        ['user_id' => 14, 'car_id' => 14, 'start_date' => '2024-07-14', 'end_date' => '2024-07-18', 'total_price' => 330.00, 'status' => 'confirmed'],
        ['user_id' => 15, 'car_id' => 15, 'start_date' => '2024-07-15', 'end_date' => '2024-07-19', 'total_price' => 340.00, 'status' => 'pending'],
        ['user_id' => 16, 'car_id' => 16, 'start_date' => '2024-07-16', 'end_date' => '2024-07-20', 'total_price' => 350.00, 'status' => 'confirmed'],
        ['user_id' => 17, 'car_id' => 17, 'start_date' => '2024-07-17', 'end_date' => '2024-07-21', 'total_price' => 360.00, 'status' => 'cancelled'],
        ['user_id' => 18, 'car_id' => 18, 'start_date' => '2024-07-18', 'end_date' => '2024-07-22', 'total_price' => 370.00, 'status' => 'confirmed'],
        ['user_id' => 19, 'car_id' => 19, 'start_date' => '2024-07-19', 'end_date' => '2024-07-23', 'total_price' => 380.00, 'status' => 'pending'],
        ['user_id' => 20, 'car_id' => 20, 'start_date' => '2024-07-20', 'end_date' => '2024-07-24', 'total_price' => 390.00, 'status' => 'confirmed'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'car_id' => \App\Models\Car::factory(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'total_price' => $this->faker->randomFloat(2, 100, 1000),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
