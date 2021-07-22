<?php

namespace App\Http\Controllers;

use App\Services\GetInvoices;
use App\Services\Mercadopago\CreatePreferent;
use App\Services\ValidateInvoices;
use Esatic\Suitecrm\Facades\Suitecrm;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DemoController extends Controller
{


    private CreatePreferent $createPreferent;
    private array $invoicesToPay = array();

    /**
     * CreatePreferent constructor.
     * @param CreatePreferent $createPreferent
     */
    public function __construct(CreatePreferent $createPreferent)
    {
        $this->createPreferent = $createPreferent;
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
       
        if ($invoices == false) {
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
            return Inertia::render('invoices/summaryInvoices')->with('invoicespay',$validateInvoices->getInvoicesToPay())->with('preferenceid',$preferenceId);
        }
        return Inertia::render('invoices/noDniFound')->with('error', 'newinvoice');
    }

    public function redirectThanks(Request $request,string $dni)
    {
        // dd($request->all());

        return Inertia::render('invoices/thakpage')->with('invoices',$request->input('invoices'))->with('statuspay',$request->input('statuspay'));
    }

}
