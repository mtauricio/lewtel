<?php

namespace App\Http\Controllers;

use App\Services\GetInvoicesLogin;
use App\Services\GetTickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Str;

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

    public function toLogout()
    { 
        $url = route('logout');
        return Inertia::location($url);
    }

    public function showResetForm()
    {
        return Inertia::render('dashboard/profile/reserPassword')->with('id', auth()->user()->id);
    }

    public function showProfile()
    {
        return Inertia::render('dashboard/profile/profile') 
        ->with('name',auth()->user()->name)
        ->with('lastName',auth()->user()->last_name)
        ->with('email', auth()->user()->email);
    }
}
