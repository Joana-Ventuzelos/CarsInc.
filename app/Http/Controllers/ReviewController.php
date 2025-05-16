<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('review.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('review.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'review' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Store the review in the database
        // Review::create($request->all());

        // Redirect to the reviews index with a success message
        return redirect()->route('review.index')->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the review by id
         // $review = Review::findOrFail($id);

        // Return the view with the review data
         return view('review.show', compact('review'));
        return view('review.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the review by id
        // $review = Review::findOrFail($id);

        // Return the view to edit the review
        return view('review.edit', compact('review'));
        return view('review.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'review' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Update the review in the database
        // Review::findOrFail($id)->update($request->all());

        // Redirect to the reviews index with a success message
        return redirect()->route('review.index')->with('success', 'Review updated successfully.');
        return view('review.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the review from the database
        // Review::destroy($id);

        // Redirect to the reviews index with a success message
        return redirect()->route('review.index')->with('success', 'Review deleted successfully.');
        return view('review.index');
    }
}
