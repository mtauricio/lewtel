<?php

namespace App\Http\Controllers;

use App\Services\GetInvoicesLogin;
use App\Services\GetTickets;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private GetTickets $getTickets;
    private GetInvoicesLogin $getInvoicesLogin;

    public function __construct(GetTickets $getTickets, GetInvoicesLogin $getInvoicesLogin)
    {
        $this->middleware('auth');
        $this->getTickets = $getTickets;
        $this->getInvoicesLogin = $getInvoicesLogin;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allTickets = $this->getTickets->execute(null);
        $tickets = $this->getTickets->execute('open');
        $invoices = $this->getInvoicesLogin->execute(null);
        $allInvoices = $this->getInvoicesLogin->execute('pay');
        return Inertia::render('dashboard/home')
            ->with('allTickets',count($allTickets))
            ->with('openTickets',count($tickets))
            ->with('unpaidInvoices',count($invoices))
            ->with('allInvoices',count($allInvoices));
    }
}
