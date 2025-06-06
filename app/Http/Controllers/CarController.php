<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Car\CarService;
use App\Models\Rental;

class CarController extends Controller
{
    private CarService $carService;

    public function __construct()
    {
        $this->carService = new CarService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $brand = $request->input('brand');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $carsQuery = \App\Models\Car::with(['localizacoes', 'bensLocaveis']);

        if ($query) {
            $carsQuery->where(function ($q) use ($query) {
                $q->where('brand', 'like', '%' . $query . '%')
                  ->orWhere('model', 'like', '%' . $query . '%')
                  ->orWhere('license_plate', 'like', '%' . $query . '%');
            });
        }

        if ($brand) {
            $carsQuery->where('brand', 'like', '%' . $brand . '%');
        }

        if ($minPrice) {
            $carsQuery->where('price_per_day', '>=', $minPrice);
        }

        if ($maxPrice) {
            $carsQuery->where('price_per_day', '<=', $maxPrice);
        }

        $cars = $carsQuery->orderBy('brand')->paginate(30)->appends([
            'search' => $query,
            'brand' => $brand,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ]);

        $characteristics = [];
        foreach ($cars as $car) {
            $characteristics[$car->id] = $car->getCharacteristics();
            $characteristics[$car->id]['bens_locaveis'] = \App\Models\BensLocaveis::with('marca')
                ->whereHas('marca', function($q) use ($car) {
                    $q->where('nome', $car->brand);
                })->get();
        }

        return view('car.index', compact('cars', 'characteristics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_name' => 'required|string|max:255',
            'car_model' => 'required|string|max:255',
            'car_price' => 'required|numeric|min:0',
            'car_brand' => 'required|string|max:255',
            'car_year' => 'required|integer|min:1886|max:' . date('Y'),
            'car_color' => 'required|string|max:255',
            'car_mileage' => 'required|integer|min:0',
            'car_transmission' => 'required|string|in:manual,automatic',
            'car_fuel_type' => 'required|string|in:gasoline,diesel,electric,hybrid',
            'car_doors' => 'required|integer|min:2|max:5',
            'car_seats' => 'required|integer|min:2|max:7',
            'car_air_conditioning' => 'required|boolean',
            'car_bluetooth' => 'required|boolean',
            'car_navigation' => 'required|boolean',
        ]);

        // For simplicity, using Eloquent directly here, can be refactored similarly
        // to use application service if needed.
        \App\Models\Car::create($request->all());

        return redirect()->route('car.index')->with('success', 'Car created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = \App\Models\Car::with('localizacoes')->findOrFail($id);


        $characteristics = $car->getCharacteristics();

        return view('car.show', compact('car', 'characteristics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = \App\Models\Car::findOrFail($id);
        return view('car.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'car_name' => 'required|string|max:255',
            'car_model' => 'required|string|max:255',
            'car_price' => 'required|numeric|min:0',
        ]);

        $car = \App\Models\Car::findOrFail($id);
        $car->update($request->all());

        return redirect()->route('car.index')->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = \App\Models\Car::findOrFail($id);
        $car->delete();

        return redirect()->route('car.index')->with('success', 'Car deleted successfully.');
    }
}
