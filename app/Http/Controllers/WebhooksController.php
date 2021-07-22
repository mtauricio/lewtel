<?php

namespace App\Http\Controllers;

use App\Services\SaveInvoices;
use App\Services\SavePayments;
use App\Services\UpdateInvoiceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhooksController extends Controller
{

    private SavePayments $savePayments;
    private SaveInvoices $saveInvoices;
    private UpdateInvoiceStatus $updateInvoiceStatus;

      /**
     * SavePayments constructor.
     * @param SavePayments $savePayments
     */
    public function __construct(SavePayments $savePayments, SaveInvoices $saveInvoices,UpdateInvoiceStatus $updateInvoiceStatus)
    {
        $this->savePayments = $savePayments;
        $this->saveInvoices = $saveInvoices;
        $this->updateInvoiceStatus = $updateInvoiceStatus;
    }
    public function __invoke( Request $request)
    {
        $status = "";
        $payment_id = $request->input('data_id');
        $token = env('MP_ACCESS_TOKEN');
        Log::info($payment_id);
        Log::info($token);
        
        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=$token");
        $response = json_decode($response);
        Log::info(json_encode($response));
       if (!isset($response->error)) {
        $status = $response->status;
        $items = $response->additional_info->items;

        if ($status) {
            $idPayment = $this->savePayments->execute($response);
            $this->saveInvoices->execute($idPayment, $items);
            $this->updateInvoiceStatus->execute($items,$response->status);
            http_response_code(200);
        }
       }
       http_response_code(200);

       
    }
}
