<?php


namespace App\Services;

use App\Models\Payments;
use Carbon\Carbon;
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
        if ($response->status) {
            $payment = Payments::query()->findOrFail($response->external_reference);
            $payment->payment_id = $response->id;
            $payment->status = $response->status;
            $payment->customer_id = $response->payer->id;
            $payment->payment_at = Carbon::parse($response->date_approved);
            $payment->save();
            return $payment;
        }
        throw new \Exception(__('Payment failed'));
    }


}
