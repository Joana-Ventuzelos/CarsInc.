<?php

namespace App\Http\Controllers;

use App\Mail\ReservationConfirmationMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Reserva;


class ReservationConfirmationMailController extends Controller
{
    public function sendReservationEmail(Request $request)
    {
        $user = Auth::user();
        $clientName = $user->name;
        $email = $user->email;
        $local = $request->input('pickup');

        // Envie o e-mail de confirmação
        Mail::to($email)
            ->send(new \App\Mail\ReservationConfirmationMail($clientName, $local));

        // Exibe a mesma view do email após enviar
        return view('mail.reservation-confirmation-mail', [
            'client' => $clientName,
            'local' => $local,
        ]);
    }

    public function generatePdf(Request $request)
    {
        $user = Auth::user();
        $clientName = $user->name;
        $clientEmail = $user->email;

        $rental = \App\Models\Rental::with(['car.caracteristicas', 'payments'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $car = null;
        $location = null;
        $startDate = null;
        $endDate = null;
        $days = null;
        $userType = 'N/A';
        $features = [];
        $paymentMethod = 'N/A';
        $status = 'N/A';

        if ($rental) {
            $car = $rental->car;
            $location = $rental->location;
            $startDate = \Carbon\Carbon::parse($rental->start_date)->format('Y-m-d');
            $endDate = \Carbon\Carbon::parse($rental->end_date)->format('Y-m-d');
            $days = $rental->end_date->diffInDays($rental->start_date) + 1;
            $features = $car && $car->caracteristicas ? $car->caracteristicas : [];
            $paymentMethod = $rental->payments && $rental->payments->isNotEmpty() ? ucfirst($rental->payments->first()->payment_method) : 'ATM';
            $status = ucfirst($rental->status ?? 'N/A');
            $userType = 'user'; // or fetch actual user type if needed
        }

        $userType = 'user'; // or fetch actual user type if needed

        $pdf = Pdf::loadView('reservation.pdf', compact('clientName', 'clientEmail', 'car', 'location', 'startDate', 'endDate', 'days', 'userType', 'features', 'paymentMethod', 'status', 'rental'));
        return $pdf->download('reservation-confirmation.pdf');
    }

    public function showSendConfirmationForm(Request $request)
    {
        $user = Auth::user();
        $carId = $request->query('car_id');
        $car = null;
        if ($carId) {
            $car = \App\Models\Car::with('caracteristicas')->find($carId);
        }
        return view('send_confirmation', compact('car', 'user'));
    }

    public function sendConfirmationEmail(Request $request)
    {
        $user = Auth::user();
        $clientName = $request->input('client_name');
        $email = $user->email;

        $carId = $request->input('car_id');
        $car = \App\Models\Car::find($carId);

        if (!$car) {
            return redirect()->back()->withErrors(['error' => 'Invalid car selected.']);
        }

        // Send confirmation email
        Mail::to($email)
            ->send(new \App\Mail\ReservationConfirmationMail($clientName, $car->brand));

        // Exibe a mesma view do email após enviar
        return view('mail.reservation-confirmation-mail', [
            'client' => $clientName,
            'local' => $car->brand,
        ]);
    }
}
