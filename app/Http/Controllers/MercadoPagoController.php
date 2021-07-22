<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Mercadopago\CreatePreferent;
use App\Services\SaveInvoices;
use App\Services\SavePayments;
use App\Services\UpdateInvoiceStatus;
use Illuminate\Support\Facades\Http;

class MercadoPagoController extends Controller
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
    public function getPayment( Request $request, $dni )
    {

        $payment_id = $request->input('payment_id');
        $token = env('MP_ACCESS_TOKEN');
        
        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=$token");
        $response = json_decode($response);

        // dd($response);

        $status = $response->status;
        $items = $response->additional_info->items;

        if ($status == 'approved') {
            $idPayment = $this->savePayments->execute($response);
            $this->saveInvoices->execute($idPayment, $items);
            $this->updateInvoiceStatus->execute($items);
        }
    }
}