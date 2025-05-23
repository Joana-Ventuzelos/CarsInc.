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
        $rental_id = $request->query('rental_id');
        return view('payment.create', ['rental_id' => $rental_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'rental_days' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $amount = $request->rental_days * 50;

        if ($request->payment_method === 'paypal') {
            try {
                $payment = $this->paypalService->createPayment(
                    $amount,
                    route('payment.success'),
                    route('payment.cancel')
                );

                foreach ($payment->getLinks() as $link) {
                    if ($link->getRel() === 'approval_url') {
                        return redirect()->away($link->getHref());
                    }
                }

                return redirect()->back()->with('error', 'Unable to process PayPal payment.');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Error processing PayPal payment: ' . $e->getMessage());
            }
        } else {
            $payment = new \App\Models\Payment();
            $payment->rental_id = $request->rental_id;
            $payment->amount = $amount;
            $payment->payment_method = $request->payment_method;
            $payment->description = $request->description;
            $payment->save();

            return redirect()->route('rental.index')->with('success', 'Payment created successfully.');
        }
    }
}
