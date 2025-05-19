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
    public function index()
    {
        // For simplicity, using Eloquent directly here, can be refactored similarly
        // to use application service if needed.
        $cars = \App\Models\Car::with('localizacoes')->paginate(30);

        $characteristics = [];
        foreach ($cars as $car) {
            $characteristics[$car->id] = $car->getCharacteristics();
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
        $car = $this->carService->getCarById($id);
        if (!$car) {
            abort(404);
        }
        return view('car.show', ['car' => $car]);
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
