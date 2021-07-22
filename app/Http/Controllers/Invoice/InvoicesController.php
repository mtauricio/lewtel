<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Services\GetInvoicesLogin;
use App\Services\Mercadopago\CreatePreferent;
use App\Services\ValidateInvoices;
use Esatic\Suitecrm\Facades\Suitecrm;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoicesController extends Controller
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
            return Inertia::render('dashboard/invoices/summaryInvoices')->with('invoicespay', $validateInvoices->getInvoicesToPay())->with('preferenceid', $preferenceId);
        }
        return Inertia::render('dashboard/invoices/noDniFound')->with('error', 'newinvoice');
    }

    public function redirectThanks(Request $request)
    {
        // dd($request->all());

        return Inertia::render('dashboard/invoices/thakpage')->with('invoices', $request->input('invoices'))->with('statuspay', $request->input('statuspay'));
    }
}
