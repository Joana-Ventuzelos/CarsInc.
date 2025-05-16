<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all rentals from the database
        // $rentals = Rental::all();

        // Return the view with the rentals data
        return view('rental.index');
        // return view('rental.index', compact('rentals'));
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
        // Rental::create($request->all());

        // Redirect to the rentals index with a success message
        return redirect()->route('rental.index')->with('success', 'Rental created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the rental by id from the database
        // $rental = Rental::findOrFail($id);
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
        // $rental = Rental::findOrFail($id);

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
        // $rental = Rental::findOrFail($id);
        // $rental->update($request->all());

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
        // $rental = Rental::findOrFail($id);

        // Delete the rental from the database
        // $rental->delete();

        // Redirect to the rentals index with a success message
        return redirect()->route('rental.index')->with('success', 'Rental deleted successfully.');
        // return view('rental.index');
    }
}
