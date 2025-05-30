<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationConfirmationMailController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationHistoryController;
use App\Http\Controllers\PayPalController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/enviar-email', [ReservationConfirmationMailController::class, 'sendReservationEmail'])
    ->middleware('auth')
    ->name('send.email');
Route::resource('users', UserController::class);
Route::resource('car', CarController::class);
Route::resource('rental', RentalController::class);
Route::resource('review', ReviewController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('rental/create', [RentalController::class, 'create'])->name('rental.create');
    Route::post('rental/store-and-redirect', [RentalController::class, 'storeAndRedirect'])->name('rental.storeAndRedirect');
    Route::get('rental/fatura/{rental}', [RentalController::class, 'fatura'])->name('rental.fatura');

    Route::get('/reservation-history', [ReservationHistoryController::class, 'index'])->name('reservation.history');
});
// Route::get('transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
// Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
// Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
// Route::get('finish-transaction', [PayPalController::class, 'finishTransaction'])->name('finishTransaction');

require __DIR__.'/auth.php';
Route::get('atm', [RentalController::class, 'getpayment'])->name('atm');
Route::get('/reservation-history', [\App\Http\Controllers\RentalController::class, 'reservationHistory'])->name('reservation.history');



