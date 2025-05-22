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
        // Create regular user
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'nif' => '123456789',
            'is_admin' => false,
        ]);

        // Create admin user
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'nif' => '987654321',
        ]);

        // Seed cars from CarFactory examples
        foreach (\Database\Factories\CarFactory::$examples as $carData) {
            Car::create($carData);
        }

        // Seed rentals from RentalFactory examples
        foreach (\Database\Factories\RentalFactory::$examples as $rentalData) {
            Rental::create($rentalData);
        }

        // Seed localizacoes
        $this->call(LocalizacaoSeeder::class);
    }
}
