<?php


namespace App\Http\Controllers;

use App\Mail\ReservationConfirmationMail;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use App\Models\Marca;
use App\Models\BensLocaveis;
use Illuminate\Support\Facades\Auth;


class RentalController extends Controller
{
    public function getpayment(Request $request)

        // 1. Validate the incoming data
    {
        $data = $request->validate([
        'car_id' => 'required|exists:cars,id',
        'days' => 'required|integer|min:1',
    ]);


        // 2. Get the car and calculate the amount
        $car = \App\Models\Car::findOrFail($data['car_id']);
        $amount = number_format($car->price_per_day * $data['days'], 2, '.', '');



        $atm= rand(10000000, 99999999); // Generate a random ATM number
 //       $car->price_per_day * $data['days'];


        $pendingRental = [
            'car_id' => $car->id,
            'days' => $data['days'],
            'amount' => $amount,
        ];
        session([
            'pending_rental' => [
                'car_id' => $car->id,
                'days' => $data['days'],
                'amount' => $amount,
            ]
        ]);
        return view('transaction', compact(['atm','pendingRental']));
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
     * Display reservation history.
     */
    public function reservationHistory()
    {
        $user = Auth::user();
        $userId = $user->id;
        $userType = 'other';
        if ($user->email === 'admin@example.com') {
            $userType = 'admin';
        } elseif ($user->email === 'user@example.com') {
            $userType = 'user';
        }

        $userRentals = Rental::with(['payments', 'car'])
            ->where('user_id', $userId)
            ->orderBy('start_date', 'desc')
            ->get();
        return view('reservation.history', ['pastRentals' => $userRentals, 'userType' => $userType]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(Request $request)
    {
        $cars = \App\Models\Car::where('is_available', true)->get();
        $locations = \App\Models\Localizacao::all();
        return view('rental.create', compact('cars', 'locations'));
    }

    public function storeAndRedirect(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);

        $user = Auth::user();

        // Check reservation restrictions for regular users
        if ($user->email !== 'admin@example.com') {
            $overlappingRental = \App\Models\Rental::where('user_id', $user->id)
                ->where('car_id', $request->car_id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                          ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                          ->orWhere(function ($q) use ($request) {
                              $q->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                          });
                })
                ->exists();

            if ($overlappingRental) {
                return redirect()->back()->withErrors(['error' => 'You can only reserve the same car with non-overlapping rental dates.']);
            }
        }

        $startDate = new \DateTime($request->start_date);
        $endDate = new \DateTime($request->end_date);
        $interval = $startDate->diff($endDate);
        $days = $interval->days + 1;

        // Create rental
        $rental = \App\Models\Rental::create([
            'car_id' => $request->car_id,
            'user_id' => $user->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $request->amount,
            'status' => $request->status,
        ]);

        // Store rental id in session for payment association
        session(['rental_ids' => [$rental->id]]);

        // Store pending rental info in session for transaction page
        session([
            'pending_rental' => [
                'car_id' => $request->car_id,
                'days' => $days,
                'amount' => $request->amount,
            ]
        ]);

        // Redirect to PayPal payment page
        return redirect()->route('createTransaction');
    }

    /**
     * Show the fatura (invoice) page for a rental.
     */
    // public function fatura($rentalId)
    // {
    //     $rental = \App\Models\Rental::with('car')->findOrFail($rentalId);
    //     return view('fatura', compact('rental'));
    // }

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
        return redirect()->route('car.index')->with('success', 'Rental created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // Fetch the rental by id from the database
        $rental = Rental::findOrFail($id);
        // Return the view with the rental data
        // return view('rental.show', compact('rental'));
        return view('car.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
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
    public function update(Request $request, int $id)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,cancelled,completed',
        ]);

        // Update the rental in the database
        $rental = Rental::findOrFail($id);
        $oldStatus = $rental->status;
        $rental->status = $request->input('status');
        $rental->save();

        // If status changed to cancelled by admin, eliminate one or more cars
        $user = Auth::user();
        $isAdmin = $user && $user->email === 'admin@example.com';

        if ($isAdmin && $oldStatus !== 'cancelled' && $rental->status === 'cancelled') {
            // Eliminate one or more cars logic here
            $car = $rental->car;
            if ($car) {
                // For example, mark car as unavailable or delete
                $car->is_available = false;
                $car->save();
                // Or delete the car if required
                // $car->delete();
            }
        }

        // Redirect to the rentals index with a success message
        return redirect()->route('car.index')->with('success', 'Rental status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        // Fetch the rental by id from the database
        $rental = Rental::findOrFail($id);

        // Delete the rental from the database
        $rental->delete();

        // Redirect to the rentals index with a success message
        return redirect()->route('rental.index')->with('success', 'Rental deleted successfully.');
        // return view('rental.index');
    }

    /**
     * Store multiple rentals from car selection with days and amounts and process PayPal payment.
     */
    public function storeMultiple(Request $request)
    {
        $data = $request->validate([
            'cars' => 'required|array',
            'cars.*.car_id' => 'required|exists:cars,id',
            'cars.*.days' => 'required|integer|min:1',
            'cars.*.amount' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        $rentalIds = [];

        foreach ($data['cars'] as $carData) {
            $car = \App\Models\Car::find($carData['car_id']);
            if (!$car) {
                continue;
            }

            $rental = new Rental();
            $rental->car_id = $car->id;
            $rental->start_date = now();
            $rental->end_date = now()->addDays($carData['days']);
            $rental->total_price = $carData['amount'];
            $rental->save();

            $totalAmount += $carData['amount'];
            $rentalIds[] = $rental->id;
        }

        // Store rental IDs in session for payment association
        session(['rental_ids' => $rentalIds]);

        // Create PayPal payment
        // $paypalService = app(\App\Services\PayPalService::class);

        //     try {
        //         $payment = $paypalService->createPayment(
        //             $totalAmount,
        //             route('payment.success'),
        //             route('payment.cancel')
        //         );

        //         foreach ($payment->getLinks() as $link) {
        //             if ($link->getRel() === 'approval_url') {
        //                 return redirect()->away($link->getHref());
        //             }
        //         }

        //         return redirect()->back()->with('error', 'Unable to process PayPal payment.');
        //     } catch (\Exception $e) {
        //         return redirect()->back()->with('error', 'Error processing PayPal payment: ' . $e->getMessage());
        //     }
        // }
    }
}
