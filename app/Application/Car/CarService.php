<?php

namespace App\Application\Car;

use App\Domain\Car\Car;
use App\Domain\Car\CarService as DomainCarService;
use App\Models\Car as EloquentCarModel;

class CarService
{
    private DomainCarService $domainCarService;

    public function __construct()
    {
        $this->domainCarService = new DomainCarService();
    }

    /**
     * Example method to get a Car domain model by ID.
     */
    public function getCarById(int $id): ?Car
    {
        $carModel = EloquentCarModel::find($id);
        if (!$carModel) {
            return null;
        }
        return new Car(
            $carModel->id,
            $carModel->make,
            $carModel->model,
            $carModel->year
        );
    }

    /**
     * Example method to check if a car is vintage using domain service.
     */
    public function isCarVintage(int $id): bool
    {
        $car = $this->getCarById($id);
        if (!$car) {
            return false;
        }
        return $this->domainCarService->isVintage($car);
    }
}
