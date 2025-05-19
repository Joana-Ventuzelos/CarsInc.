<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use App\Models\BensLocaveis;

class AssignBensLocaveisToCars extends Command
{
    protected $signature = 'assign:benslocaveis';

    protected $description = 'Assign benslocaveis to each car by order';

    public function handle()
    {
        $cars = Car::orderBy('id')->get();
        $bensLocaveis = BensLocaveis::orderBy('id')->get();

        $countCars = $cars->count();
        $countBens = $bensLocaveis->count();

        if ($countCars == 0 || $countBens == 0) {
            $this->info('No cars or benslocaveis found.');
            return 0;
        }

        $this->info("Assigning benslocaveis to cars by order...");

        $carIndex = 0;
        foreach ($bensLocaveis as $bem) {
            $car = $cars[$carIndex];
            $bem->car_id = $car->id;
            $bem->save();

            $carIndex++;
            if ($carIndex >= $countCars) {
                $carIndex = 0; // Loop back if more benslocaveis than cars
            }
        }

        $this->info('Assignment completed successfully.');
        return 0;
    }
}
