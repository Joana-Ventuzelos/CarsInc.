<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all admins from the database
        // $admins = Admin::all();

        // Return the view with the admins data
        return view('admin.index');
        // return view('admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new admin
        return view('admin.create');
        // return view('admin.create', compact('admins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Store the admin in the database
        // Admin::create($request->all());

        // Redirect to the admins index with a success message
        return redirect()->route('admin.index')->with('success', 'Admin created successfully.');
        // return redirect()->route('admin.index')->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the admin by id from the database
        // $admin = Admin::findOrFail($id);

        // Return the view with the admin data
        // return view('admin.show', compact('admin'));
        return view('admin.show');
        // return view('admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the admin by id from the database
        // $admin = Admin::findOrFail($id);

        // Return the view to edit the admin
        return view('admin.edit', compact('admin'));
        // return view('admin.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the admin in the database
        // $admin = Admin::findOrFail($id);
        // $admin->update($request->all());

        // Redirect to the admins index with a success message
        return redirect()->route('admin.index')->with('success', 'Admin updated successfully.');
        // return redirect()->route('admin.index')->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // Fetch the admin by id from the database
        // $admin = Admin::findOrFail($id);

        // Delete the admin from the database
        // $admin->delete();

        // Redirect to the admins index with a success message
        return redirect()->route('admin.index')->with('success', 'Admin deleted successfully.');
        // return redirect()->route('admin.index')->with('success', 'Admin deleted successfully.');

    }
}
