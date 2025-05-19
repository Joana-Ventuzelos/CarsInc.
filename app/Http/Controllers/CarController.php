<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all cars with localizacoes from the database
        $cars = Car::with('localizacoes')->paginate(30); // Show 30 cars per page

        // Fetch characteristics for each car
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
        // Return the view for creating a new car
        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'car_name' => 'required|string|max:255',
            'car_model' => 'required|string|max:255',
            'car_price' => 'required|numeric|min:0',
        ]);

        // Store the car in the database
        Car::create($request->all());

        // Redirect to the cars index with a success message
        return redirect()->route('car.index')->with('success', 'Car created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the car by id from the database
        $car = Car::findOrFail($id);

        // Return the view with the car data
        return view('car.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the car by id from the database
        $car = Car::findOrFail($id);

        // Return the view to edit the car
        return view('car.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'car_name' => 'required|string|max:255',
            'car_model' => 'required|string|max:255',
            'car_price' => 'required|numeric|min:0',
        ]);

        // Update the car in the database
        $car = Car::findOrFail($id);
        $car->update($request->all());

        // Redirect to the cars index with a success message
        return redirect()->route('car.index')->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the car by id from the database
        $car = Car::findOrFail($id);

        // Delete the car from the database
        $car->delete();

        // Redirect to the cars index with a success message
        return redirect()->route('car.index')->with('success', 'Car deleted successfully.');
    }
}
