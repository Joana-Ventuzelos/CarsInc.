<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed cars from CarFactory examples
        foreach (\Database\Factories\CarFactory::$examples as $carData) {
            Car::create($carData);
        }

        // Seed rentals from RentalFactory examples
        foreach (\Database\Factories\RentalFactory::$examples as $rentalData) {
            Rental::create($rentalData);
        }
    }
}
