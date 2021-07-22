<?php


namespace App\Services;

use App\Models\Invoices;
use App\Models\Payments;

class SaveInvoices
{

    public function execute(Payments $payments, array $items)
    {
        $invoices = array();
        foreach ($items as $key) {
            $invoice = new Invoices();
            $invoice->number = $key->description;
            $invoice->id_crm_invoice = $key->id;
            $invoices[] = $invoice;
        }
        $payments->invoices()->saveMany($invoices);
    }


}
