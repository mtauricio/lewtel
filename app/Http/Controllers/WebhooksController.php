<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Services\SaveInvoices;
use App\Services\SavePayments;
use App\Services\UpdateInvoiceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use MercadoPago\Payment;
use MercadoPago\Preference;

class WebhooksController extends Controller
{

    private SavePayments $savePayments;
    private SaveInvoices $saveInvoices;
    private UpdateInvoiceStatus $updateInvoiceStatus;

    /**
     * SavePayments constructor.
     * @param SavePayments $savePayments
     */
    public function __construct(SavePayments $savePayments, SaveInvoices $saveInvoices, UpdateInvoiceStatus $updateInvoiceStatus)
    {
        $this->savePayments = $savePayments;
        $this->saveInvoices = $saveInvoices;
        $this->updateInvoiceStatus = $updateInvoiceStatus;
    }


    /**
     * This method is executed when webhook from mercadolibre is called
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $payment_id = $request->input('data_id');
       
        $response = Payment::get($payment_id);
        // Log::info($response);
        Log::info($response->id);
        Log::info($response->external_reference);
        // Log::info(print_r($response, true));
        $payment = $this->savePayments->execute($response);
        if (!isset($response->error)) {
            $status = $response->status;
            $items = $response->additional_info->items;
            if ($status == "approved") {
                $this->updateInvoiceStatus->execute($items, $response->status);
            }
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }
}
