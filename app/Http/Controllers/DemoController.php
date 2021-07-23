<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Services\GetInvoices;
use App\Services\Mercadopago\CreatePreferent;
use App\Services\ValidateInvoices;
use Esatic\Suitecrm\Facades\Suitecrm;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Esatic\Suitecrm\Services\CrmApi;

class DemoController extends Controller
{

    private CrmApi $apiCrm;
    private CreatePreferent $createPreferent;
    private array $invoicesToPay = array();

    /**
     * CreatePreferent constructor.
     * @param CreatePreferent $createPreferent
     */
    public function __construct(CreatePreferent $createPreferent, CrmApi $apiCrm)
    {
        $this->createPreferent = $createPreferent;
        $this->apiCrm = $apiCrm;
    }
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('invoices/payment')->with('test', 'Pruebas inertia');
    }

    /**
     * @param string $dni
     * @param GetInvoices $getInvoices
     * @return \Inertia\Response
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function all(string $dni, GetInvoices $getInvoices): \Inertia\Response
    {
        $invoices = $getInvoices->execute($dni);
       
        if ($invoices === false) {
            return Inertia::render('invoices/noDniFound')->with('error', 'nodni');
        } else {
            return Inertia::render('invoices/all')->with('invoices', $invoices)->with('dni', $dni);
        }
        
    }

    public function summary(Request $request, ValidateInvoices $validateInvoices, string $dni)
    {
        // dd($request->input('invoices'));
        if ($validateInvoices->execute($request, $request->input('invoices'))) {
            $preferenceId = $this->createPreferent->execute($request, null);
            return Inertia::render('invoices/summaryInvoices')->with('invoicespay',$validateInvoices->getInvoicesToPay())->with('preferenceid',$preferenceId->id);
        }
        return Inertia::render('invoices/noDniFound')->with('error', 'newinvoice');
    }

    public function redirectThanks(Request $request,GetInvoices $getInvoices)
    {

       $invoices = Payments::find($request->input('id_payment'))->invoices;
       $idInvoices = [];
       $invoicesPay = [];
       foreach ($invoices as $invoice) {
           $idInvoices[] = $invoice->id_crm_invoice;
       }
       
       $invoicesCrm = $this->apiCrm->getEntries('AOS_Invoices',$idInvoices);
       
        if (isset($invoicesCrm['entry_list'][0]['name_value_list']['id'])) {
            $invoicesPay =  $getInvoices->dtoData($invoicesCrm['entry_list']);
        }

        return Inertia::render('invoices/thakpage')->with('invoices',$invoicesPay)->with('statuspay',$request->input('statuspay'))->with('dni',$request->input('dniUser'));
    }

}
