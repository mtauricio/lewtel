<?php


namespace App\Services;

use App\Models\Payments;
use Esatic\Suitecrm\Services\CrmApi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SavePayments
{

    public function execute($response)
    {
        if ($response->status) {
            $payment = new Payments();
            $payment->payment_id = $response->id;
            $payment->date_created = $response->date_created;
            $payment->status = $response->status;
            $payment->customer_id = $response->payer->id;
            $payment->save();

            return $payment->id;
        }
    }


}
