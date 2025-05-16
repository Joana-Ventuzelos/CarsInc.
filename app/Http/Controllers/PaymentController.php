<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all payments from the database
        // $payments = Payment::all();

        // Return the view with the payments data
        return view('payment.index');
        // return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new payment
        return view('payment.create');
        return view('payment.create', compact('payments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Store the payment in the database
        // Payment::create($request->all());

        // Redirect to the payments index with a success message
        return redirect()->route('payment.index')->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the payment from the database
        // $payment = Payment::findOrFail($id);
        // Return the view with the payment data
        // return view('payment.show', compact('payment'));
        return view('payment.show');
        return view('payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the payment from the database
        // $payment = Payment::findOrFail($id);

        // Return the view for editing the payment
        return view('payment.edit', compact('payment'));
        return view('payment.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Update the payment in the database
        // $payment = Payment::findOrFail($id);
        // $payment->update($request->all());

        // Redirect to the payments index with a success message
        return redirect()->route('payment.index')->with('success', 'Payment updated successfully.');
        return view('payment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the payment from the database
        // $payment = Payment::findOrFail($id);

        // Delete the payment from the database
        // $payment->delete();

        // Redirect to the payments index with a success message
        return redirect()->route('payment.index')->with('success', 'Payment deleted successfully.');
        return view('payment.index');
    }
}
