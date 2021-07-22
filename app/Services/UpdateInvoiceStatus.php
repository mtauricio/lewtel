<?php


namespace App\Services;

use App\Models\Invoices;
use Esatic\Suitecrm\Services\CrmApi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UpdateInvoiceStatus
{
    private CrmApi $apiCrm;

    /**
     * GetInvoices constructor.
     * @param CrmApi $apiCrm
     */
    public function __construct(CrmApi $apiCrm)
    {
        $this->apiCrm = $apiCrm;
    }

    public function execute($items,$status)
    {
        if ($items) {
            foreach ($items as $key) {
                $setInvoiceStatus = $this->apiCrm->setEntry('AOS_Invoices',['id' => $key->id,'status' => $status]);
            }

        }
    }


}
