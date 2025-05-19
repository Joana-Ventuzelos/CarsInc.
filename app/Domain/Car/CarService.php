<?php

namespace App\Domain\Car;

class CarService
{
    /**
     * Example domain service method to check if a car is vintage.
     */
    public function isVintage(Car $car): bool
    {
        return $car->getYear() < 1990;
    }
}
