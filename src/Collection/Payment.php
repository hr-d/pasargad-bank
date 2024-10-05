<?php


namespace HRD\Pasargad\Collection;


use HRD\Pasargad\HttpClients\Request;
use HRD\Pasargad\Models\Room;

/**
 * Class Payment
 */
class Payment
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Payment constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * purchase
     * @return $this
     */
    public function purchase(string $invoice, string $invoiceDate, int $amount, string $callbackApi, string $mobileNumber = null, string $email = null)
    {
        $data = [
            "invoice" => $invoice,
            "invoiceDate" => $invoiceDate,
            "amount" => $amount,
            "callbackApi" => $callbackApi,
            "mobileNumber" => $mobileNumber,
            "payerMail" => $email,
            "serviceCode" => "8",
            "serviceType" => "PURCHASE",
            "terminalNumber" => env('PASARGAD_TERMINAL_ID'),

        ];
        try {
            $response = $this->request->make('api/payment/purchase', 'POST', $data);
        } catch (\Throwable $exception) {
            throw $exception;
        }
        if ($response['resultCode'] == 0) {
            return $response['data'];
        } else {
            return $response['resultCode'] . ' - ' . $response['resultMsg'];
        }
    }

    public function confirm(int $invoice, string $urlId)
    {
        $data = [
            "invoice" => $invoice,
            "urlId" => $urlId
        ];

        try {
            $response = $this->request->make('api/payment/confirm-transactions', 'POST', $data);
        } catch (\Throwable $exception) {
            throw $exception;
        }

        if ($response['resultCode'] == 0) {
            return $response['data'];
        } else {
            return $response['resultCode'] . ' - ' . $response['resultMsg'];
        }

    }
}
