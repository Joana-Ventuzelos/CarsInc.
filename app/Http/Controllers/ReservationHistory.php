<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rental;

class ReservationHistoryController extends Controller
{
    public function index()
    {
        $pastRentals = Rental::with(['car.caracteristicas', 'payments'])
            ->where('user_id', Auth::id())
            ->where('end_date', '<', now())
            ->orderByDesc('end_date')
            ->get();

        return view('history', compact('pastRentals')); // assumes resources/views/history.blade.php
    }
}
