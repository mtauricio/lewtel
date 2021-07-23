<?php


namespace App\Services;

use App\Models\Payments;
use Esatic\Suitecrm\Services\CrmApi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SavePayments
{

    /**
     * This method save new payment or update existing
     *
     * @param $response
     * @return Builder|Model|Payments
     * @throws \Exception
     */
    public function execute($response)
    {
        Log::info(json_encode($response));
        $payment = Payments::query()->where('payment_id', '=', $response->id)->get();
        Log::info(count($payment));
        if (count($payment) == 0) {
            $payment = new Payments();
            $payment->payment_id = $response->id;
            $payment->status = $response->status;
            $payment->customer_id = $response->payer->id;
            $payment->payment_at = $response->date_approved;
            $payment->save();
            return $payment;
        }
        throw new \Exception(__('Payment failed'));
    }


}
