<?php


namespace HRD\Alocom\Collection;


use HRD\Alocom\HttpClients\Request;
use HRD\Alocom\Models\Room;

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
    public function purchase(int $invoice, string $invoiceDate, int $amount, string $callbackApi, string $mobileNumber = null, string $email = null)
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
            $response = $this->request->make('payment/purchase', 'POST', $data);
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
            $response = $this->request->make('payment/confirm-transactions', 'POST', $data);
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
