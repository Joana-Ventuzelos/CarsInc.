<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    protected $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    /**
     * Mostra a página de transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        $pendingRental = session('pending_rental', null);
        if (!$pendingRental) {
            return redirect()->route('reservation.history');
        }
        $locations = \App\Models\Localizacao::all();
        $atm = rand(10000000, 99999999); // Generate a random reference number

        return view('transaction', [
            'pendingRental' => $pendingRental,
            'locations' => $locations,
            'atm' => $atm,
        ]);
    }

    /**
     * Processa a transação
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        // 1. Validate the incoming data
        $data = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'days' => 'required|integer|min:1',
        ]);

        // 2. Get the car and calculate the amount
        $car = \App\Models\Car::findOrFail($data['car_id']);
        $amount = number_format($car->price_per_day * $data['days'], 2, '.', '');
        $atm = $car->price_per_day * $data['days'];

        // 3. Optionally, store rental info in session for later use
        session([
            'pending_rental' => [
                'car_id' => $car->id,
                'days' => $data['days'],
                'amount' => $amount,
            ]
        ]);

        // 4. Create the PayPal order with the calculated amount
        $response = $this->payPalService->createOrder(
            route('successTransaction'),
            route('cancelTransaction'),
            $amount, // Pass the calculated amount
            'EUR'
        );

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
            logger()->error('Erro ao processar a transação - Links não encontrados ou formato inesperado', ['response' => $response]);
            return redirect()->route('createTransaction')->with('error', 'Erro ao processar a transação. Por favor, tente novamente.');
        } else {
            logger()->error('Erro na criação da ordem de pagamento', ['response' => $response]);
            // Redirect silently without error message
            return redirect()->route('createTransaction');
        }
    }

    /**
     * Sucesso da transação.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $token = $request->input('token');
        // Alternativa a linha 63 seria acessar a query string
        //$token = $request['token'];
        if (!$token) {
            return redirect()->route('cancelTransaction')->with('error', 'Token do PayPal não encontrado.');
        }

        $response = $this->payPalService->capturePaymentOrder($token);

        $name_amount = $this->payPalService->payerNameAndAmout($response);
        $payerName = $name_amount['payerName'] ?? 'Unknown Payer';
        $amount = $name_amount['amount'] ?? 'Unknown Amount';

        // Verifica se o pagamento foi completado
        if ($response['status'] ?? '' === 'COMPLETED') {
            // Redireciona para a rota de finalização com os dados de sucesso
            //Duas alternativas:
            //return redirect()->route('finishTransaction')->with('success', "Pagamento Realizado! Valor: $amount, pago por: $payerName.");
            return redirect()->route('send.confirmation.form', ['car_id' => session('pending_rental.car_id')]);
        } else {
            //diferente de withError que usamos no Recaptcha: $message só existe automaticamente dentro de @error().
            //Para mensagens comuns com with(), você acessa com session('chave'); adicionamos uma mensagem simples à sessão, com a chave 'error'
            return redirect()->route('createTransaction')->with('error', $response['message'] ?? 'Algo deu errado.');
        }
    }

    /**
     * cancela a transação.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('createTransaction')
            ->with('error', $request->input('message') ?? 'O utilizador cancelou a operação.');
    }

    public function finishTransaction(Request $request)
    {
        $amount = $request->query('amount');
        $payerName = $request->query('payer');

        // Redirect to transaction confirmation view after payment
        return redirect()->route('transaction.confirmation')->with('success', 'Payment completed.')->with('payerName', $payerName);
    }

    public function showTransactionConfirmation()
    {
        $pendingRental = session('pending_rental', null);

        if (!$pendingRental) {
            return redirect()->route('reservation.history');
        }

        $user = Auth::user();
        // Create rental using session data
        $rental = \App\Models\Rental::create([
            'car_id' => $pendingRental['car_id'],
            'user_id' => $user->id,
            'start_date' => $pendingRental['start_date'] ?? now(),
            'end_date' => $pendingRental['end_date'] ?? now()->addDays($pendingRental['days'] ?? 1),
            'total_price' => $pendingRental['amount'],
            'status' => $pendingRental['status'] ?? 'confirmed',
        ]);

        // Clear pending rental from session
        session()->forget('pending_rental');

        $locations = \App\Models\Localizacao::all();
        $atm = rand(10000000, 99999999); // Generate a random reference number

        return view('transaction_confirmation', [
            'pendingRental' => $rental,
            'locations' => $locations,
            'atm' => $atm,
        ]);
    }
}
