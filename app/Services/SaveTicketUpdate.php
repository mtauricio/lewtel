<?php


namespace App\Services;


use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\CrmApi;

class SaveTicketUpdate
{

    private CrmApi $apiCrm;
    private GetTickets $getTickets;

    /**
     * GetTickets constructor.
     * @param CrmApi $apiCrm
     */
    public function __construct(CrmApi $apiCrm, GetTickets $getTickets)
    {
        $this->apiCrm = $apiCrm;
        $this->getTickets = $getTickets;
    }


    /**
     * @return array
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function execute($request)
    {
        if ($request->input('id') != null) {
            $ticket = $this->getTickets->showTicket($request->input('id'));
            $entry = $this->apiCrm->setEntry('AOP_Case_Updates',['name' => $request->input('update'), 'description' => $request->input('update'),'assigned_user_id' => $ticket['assigned_user_id']]);
            $idNewEntry = $entry['id'];
            $caseId = $request->input('id');
            $result = $this->apiCrm->setRelationship('Cases', $caseId, 'aop_case_updates', [$idNewEntry], array());
            return $result;
        }
        
        return false;
    }


}
