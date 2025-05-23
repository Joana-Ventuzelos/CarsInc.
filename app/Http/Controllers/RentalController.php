<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use App\Models\Marca;
use App\Models\BensLocaveis;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $brand = $request->input('brand');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $rentalsQuery = Rental::query();
        $carsQuery = Car::with('caracteristicas');

        if ($query) {
            $carsQuery->where(function ($q) use ($query) {
                $q->where('brand', 'like', '%' . $query . '%')
                  ->orWhere('model', 'like', '%' . $query . '%')
                  ->orWhere('license_plate', 'like', '%' . $query . '%');
            });

            $rentalsQuery->whereHas('car', function ($q) use ($query) {
                $q->where('brand', 'like', '%' . $query . '%')
                  ->orWhere('model', 'like', '%' . $query . '%')
                  ->orWhere('license_plate', 'like', '%' . $query . '%');
            });
        }

        if ($brand) {
            $carsQuery->where('brand', 'like', '%' . $brand . '%');
            $rentalsQuery->whereHas('car', function ($q) use ($brand) {
                $q->where('brand', 'like', '%' . $brand . '%');
            });
        }

        if ($minPrice) {
            $carsQuery->where('price_per_day', '>=', $minPrice);
            $rentalsQuery->whereHas('car', function ($q) use ($minPrice) {
                $q->where('price_per_day', '>=', $minPrice);
            });
        }

        if ($maxPrice) {
            $carsQuery->where('price_per_day', '<=', $maxPrice);
            $rentalsQuery->whereHas('car', function ($q) use ($maxPrice) {
                $q->where('price_per_day', '<=', $maxPrice);
            });
        }

        $rentals = $rentalsQuery->orderBy('start_date', 'desc')->paginate(30)->appends([
            'search' => $query,
            'brand' => $brand,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ]);
        $cars = $carsQuery->paginate(30)->appends([
            'search' => $query,
            'brand' => $brand,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ]);

        // Fetch past rentals for reservation history (end_date in the past)
        $pastRentals = Rental::where('end_date', '<', now())->orderBy('end_date', 'desc')->get();

        return view('rental.index', ['rentals' => $rentals, 'cars' => $cars, 'pastRentals' => $pastRentals, 'search' => $query, 'brand' => $brand, 'minPrice' => $minPrice, 'maxPrice' => $maxPrice]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view to create a new rental
        return view('rental.create');
        // return view('rental.create', compact('rentals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'rental_name' => 'required|string|max:255',
            'rental_price' => 'required|numeric|min:0',
            'rental_description' => 'nullable|string|max:1000',
        ]);

        // Store the rental in the database
        Rental::create($request->all());

        // Redirect to the rentals index with a success message
        return redirect()->route('rental.index')->with('success', 'Rental created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the rental by id from the database
        $rental = Rental::findOrFail($id);
        // Return the view with the rental data
        // return view('rental.show', compact('rental'));
        return view('rental.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the rental by id from the database
        $rental = Rental::findOrFail($id);

        // Return the view to edit the rental
        // return view('rental.edit', compact('rental'));
        return view('rental.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'rental_name' => 'required|string|max:255',
            'rental_price' => 'required|numeric|min:0',
            'rental_description' => 'nullable|string|max:1000',
        ]);

        // Update the rental in the database
        $rental = Rental::findOrFail($id);
        $rental->update($request->all());

        // Redirect to the rentals index with a success message
        return redirect()->route('rental.index')->with('success', 'Rental updated successfully.');
        // return view('rental.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the rental by id from the database
        $rental = Rental::findOrFail($id);

        // Delete the rental from the database
        $rental->delete();

        // Redirect to the rentals index with a success message
        return redirect()->route('rental.index')->with('success', 'Rental deleted successfully.');
        // return view('rental.index');
    }
}
