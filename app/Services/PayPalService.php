<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    protected $provider;

    public function __construct()
    {
        // Instância do PayPalClient
        $this->provider = new PayPalClient;
        //Defino as credenciais(extraio do config/paypal.php)
        $this->provider->setApiCredentials(config('paypal'));
        //Uso as credenciais para enviar uma requisição ao PayPal e obter um token de acesso (access_token).
        $this->provider->getAccessToken();
    }

    /**
     * Cria uma nova ordem de pagamento no PayPal
     *
     * @param string $returnUrl
     * @param string $cancelUrl
     * @param float $amount
     * @param string $currency
     * @return array
     */
    public function createOrder($returnUrl, $cancelUrl, $amount = 1.00, $currency = 'EUR')
    {
        $response = $this->provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => $returnUrl,
                "cancel_url" => $cancelUrl,
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $currency,
                        "value" => $amount
                    ]
                ]
            ]
        ]);

        return $response;
    }

    /**
     * Captura a transação do PayPal após aprovação
     *
     * @param string $token
     * @return array
     */
    public function capturePaymentOrder($token)
    {
        return $this->provider->capturePaymentOrder($token);
    }


    /**
     * Extrai o nome do pagador (payer) e o valor pago a partir de uma resposta da API do PayPal.
     *
     *
     * @param array $response
     * @return array com "payerName' e 'amount'
     */
    public function payerNameAndAmout($response) {
        $payerName = '';
        $amount = '';

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $payerName = '';
            if (isset($response['payer']['name'])) {
                $firstName = $response['payer']['name']['given_name'] ?? '';
                $lastName = $response['payer']['name']['surname'] ?? '';
                $payerName = trim($firstName . ' ' . $lastName);
            }

            $amount = '';
            $currency = '';
            if (isset($response['purchase_units'][0]['payments']['captures'][0]['amount'])) {
                $amountData = $response['purchase_units'][0]['payments']['captures'][0]['amount'];
                $amount = $amountData['value'] ?? '';
                $currency = $amountData['currency_code'] ?? '';
            }
        }
        return compact('payerName', 'amount');
    }
}
