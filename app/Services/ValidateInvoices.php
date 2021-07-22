<?php


namespace App\Services;


use Esatic\Suitecrm\Services\CrmApi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ValidateInvoices
{

    private GetInvoices $getInvoices;
    private GetInvoicesLogin $getInvoicesLogin;
    private array $invoicesToPay = array();

    /**
     * ValidateInvoices constructor.
     * @param GetInvoices $getInvoices
     */
    public function __construct(GetInvoices $getInvoices, GetInvoicesLogin $getInvoicesLogin)
    {
        $this->getInvoices = $getInvoices;
        $this->getInvoicesLogin = $getInvoicesLogin;
    }


    public function execute(Request $request, array $invoiceIds)
    {
        $invoices = '';
        if (isset($request->dni) ) {
            
            $invoices = $this->getInvoices->execute($request->dni);
        }else {
            
            $invoices = $this->getInvoicesLogin->execute(null);
        }

        $valid = true;
        $limit = count($invoiceIds);
        $collection = new Collection($invoices);
        $newCollection = $collection->take($limit);
        foreach ($newCollection as $item) {
            if (!in_array($item['id'], $invoiceIds)) {
                $valid = false;
                break;
            }
            $this->invoicesToPay[] = $item;
        }
        // dd($this->invoicesToPay);
        return $valid;
    }

    /**
     * @return array
     */
    public function getInvoicesToPay(): array
    {
        return $this->invoicesToPay;
    }


}
