<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Services\GetTickets;
use App\Services\SaveTicketCrm;
use App\Services\SaveTicketUpdate;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function GuzzleHttp\Promise\all;

class TicketController extends Controller
{
    
    private GetTickets $getTickets;
    private SaveTicketCrm $saveTicketCrm;
    private SaveTicketUpdate $saveTicketUpdate;

    /**
     * GetTickets constructor.
     * @param GetTickets $getTickets
     */
    public function __construct(GetTickets $getTickets,SaveTicketCrm $saveTicketCrm, SaveTicketUpdate $saveTicketUpdate)
    {
        $this->getTickets = $getTickets;
        $this->saveTicketCrm = $saveTicketCrm;
        $this->saveTicketUpdate = $saveTicketUpdate;
    }
    /**
     * @return \Inertia\Response
     */

     public function index(Request $request)
     {
        $tickets = $this->getTickets->execute($request->input('open'));
        
        return Inertia::render('dashboard/tickets/ticketsTable')->with('tickets', $tickets);
     }

     public function show($id)
     {
         $ticket = $this->getTickets->showTicket($id);
         $updates = $this->getTickets->showTicketUpdates($id);
         return Inertia::render('dashboard/tickets/ticket')->with('ticket', $ticket)->with('updates', $updates);
     }

     public function create()
     {
        return Inertia::render('dashboard/tickets/createTicket');
     }

     public function storeCase(Request $request)
     {
        $result = $this->saveTicketCrm->execute($request);
        $response = "";
        foreach ($result as $key => $value) {
           if ($value > 0) {
            $response = $key;
           }
        }
        return Inertia::render('dashboard/tickets/createTicket')->with('result',$response);
     }

     public function updateCase(Request $request)
     {

        $result = $this->saveTicketUpdate->execute($request);
        $ticket = $this->getTickets->showTicket($request->input('id'));
         $updates = $this->getTickets->showTicketUpdates($request->input('id'));
        $response = "";
        foreach ($result as $key => $value) {
           if ($value > 0) {
            $response = $key;
           }
        }
        return Inertia::render('dashboard/tickets/ticket')->with('result',$response)
        ->with('ticket', $ticket)->with('updates', $updates);
     }
}
