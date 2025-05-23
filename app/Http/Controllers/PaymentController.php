<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;
use Exception;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    /**
     * API endpoint to create PayPal payment
     */
    public function createPaypalPayment(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $payment = $this->paypalService->createPayment(
                $request->amount,
                route('payment.success'),
                route('payment.cancel')
            );

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() === 'approval_url') {
                    return response()->json(['approval_url' => $link->getHref()]);
                }
            }

            return response()->json(['error' => 'Unable to process PayPal payment.'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error processing PayPal payment: ' . $e->getMessage()], 500);
        }
    }

    /**
     * API endpoint to execute PayPal payment
     */
    public function executePaypalPayment(Request $request): JsonResponse
    {
        $request->validate([
            'paymentId' => 'required|string',
            'PayerID' => 'required|string',
        ]);

        try {
            $result = $this->paypalService->executePayment($request->paymentId, $request->PayerID);

            // Save payment record in database
            $payment = new \App\Models\Payment();
            $payment->rental_id = $request->session()->get('rental_id');
            $payment->amount = $result->getTransactions()[0]->getAmount()->getTotal();
            $payment->payment_method = 'paypal';
            $payment->description = 'PayPal payment completed';
            $payment->save();

            return response()->json(['success' => true, 'message' => 'Payment completed successfully.']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Payment execution failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $rentalIds = session('rental_ids', []);
        $rentals = \App\Models\Rental::whereIn('id', $rentalIds)->get();

        $amount = $rentals->sum('total_price');

        return view('payment.create', ['rental_ids' => $rentalIds, 'amount' => $amount]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rental_ids' => 'required|array',
            'rental_ids.*' => 'required|exists:rentals,id',
            'amounts' => 'required|array',
            'amounts.*' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $totalAmount = array_sum($request->amounts);

        if ($request->payment_method === 'paypal') {
            try {
                $payment = $this->paypalService->createPayment(
                    $totalAmount,
                    route('payment.success'),
                    route('payment.cancel')
                );

                foreach ($payment->getLinks() as $link) {
                    if ($link->getRel() === 'approval_url') {
                        // Store rental_ids and amounts in session for success callback
                        session(['rental_ids' => $request->rental_ids, 'amounts' => $request->amounts]);
                        return redirect()->away($link->getHref());
                    }
                }

                return redirect()->back()->with('error', 'Unable to process PayPal payment.');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Error processing PayPal payment: ' . $e->getMessage());
            }
        } else {
            foreach ($request->rental_ids as $index => $rentalId) {
                $payment = new \App\Models\Payment();
                $payment->rental_id = $rentalId;
                $payment->amount = $request->amounts[$index];
                $payment->payment_method = $request->payment_method;
                $payment->description = $request->description;
                $payment->save();
            }

            return redirect()->route('rental.index')->with('success', 'Payments created successfully.');
        }
    }

    /**
     * Handle PayPal payment success callback
     */
    public function success(Request $request)
    {
        $paymentId = $request->query('paymentId');
        $payerId = $request->query('PayerID');

        $rentalIds = session('rental_ids', []);
        $amounts = session('amounts', []);

        if (!$paymentId || !$payerId) {
            return redirect()->route('reservation.history')->with('error', 'Payment was not successful.');
        }

        try {
            $result = $this->paypalService->executePayment($paymentId, $payerId);

            if ($result->getState() === 'approved') {
                // Update rentals and create payment records
                foreach ($rentalIds as $index => $rentalId) {
                    $rental = \App\Models\Rental::find($rentalId);
                    if ($rental) {
                        $rental->status = 'confirmed';
                        $rental->save();

                        $paymentRecord = new \App\Models\Payment();
                        $paymentRecord->rental_id = $rentalId;
                        $paymentRecord->amount = $amounts[$index] ?? 0;
                        $paymentRecord->payment_method = 'paypal';
                        $paymentRecord->description = 'PayPal payment';
                        $paymentRecord->save();
                    }
                }

                // Clear session data
                session()->forget(['rental_ids', 'amounts']);

                return redirect()->route('reservation.history')->with('success', 'Payment successful and reservations confirmed.');
            } else {
                return redirect()->route('reservation.history')->with('error', 'Payment was not approved.');
            }
        } catch (Exception $e) {
            return redirect()->route('reservation.history')->with('error', 'Payment execution failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle PayPal payment cancellation
     */
    public function cancel()
    {
        return redirect()->route('reservation.history')->with('error', 'Payment was cancelled.');
    }
}
