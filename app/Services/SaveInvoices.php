<?php


namespace App\Services;

use App\Models\Invoices;
use Esatic\Suitecrm\Services\CrmApi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SaveInvoices
{

    public function execute($payment_id, $items)
    {
        if ($payment_id) {
            foreach ($items as $key) {
                $invoice = new Invoices();
                $invoice->number = $key->description;
                $invoice->id_crm_invoice = $key->id;
                $invoice->paymets_id = $payment_id;
                $invoice->save();
            }

        }
    }


}
