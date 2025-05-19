<?php

namespace App\Domain\Car;

class Car
{
    private int $id;
    private string $make;
    private string $model;
    private int $year;

    public function __construct(int $id, string $make, string $model, int $year)
    {
        $this->id = $id;
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMake(): string
    {
        return $this->make;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
