<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use App\Services\GetInvoicesLogin;
use App\Services\Mercadopago\CreatePreferent;
use App\Services\ValidateInvoices;
use Esatic\Suitecrm\Facades\Suitecrm;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Esatic\Suitecrm\Services\CrmApi;

class InvoicesController extends Controller
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
     * @param GetInvoicesLogin $getInvoices
     * @return \Inertia\Response
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function allInvoices(Request $request, GetInvoicesLogin $getInvoices): \Inertia\Response
    {
        $invoices = $getInvoices->execute($request->input('pay'));
        return Inertia::render('dashboard/invoices/invoicesTable')->with('invoices', $invoices)->with('pay', $request->input('pay'));

    }

    /**
     * @param Request $request
     * @param ValidateInvoices $validateInvoices
     * @return \Inertia\Response
     * @throws \Exception
     */
    public function summary(Request $request, ValidateInvoices $validateInvoices)
    {
        if ($validateInvoices->execute($request, $request->input('invoices'))) {
            $preferenceId = $this->createPreferent->execute($request, true);
            return Inertia::render('dashboard/invoices/summaryInvoices')->with('invoicespay', $validateInvoices->getInvoicesToPay())->with('preferenceid', $preferenceId->id);
        }
        return Inertia::render('dashboard/invoices/noDniFound')->with('error', 'newinvoice');
    }

    public function redirectThanks(Request $request, GetInvoicesLogin $getInvoices)
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

        return Inertia::render('dashboard/invoices/thakpage')->with('invoices', $invoicesPay)->with('statuspay', $request->input('statuspay'));
    }
}
