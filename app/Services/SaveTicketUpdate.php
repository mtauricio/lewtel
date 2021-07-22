<?php


namespace App\Services;


use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\CrmApi;

class SaveTicketUpdate
{

    private CrmApi $apiCrm;

    /**
     * GetTickets constructor.
     * @param CrmApi $apiCrm
     */
    public function __construct(CrmApi $apiCrm)
    {
        $this->apiCrm = $apiCrm;
    }


    /**
     * @return array
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function execute($request)
    {
        if ($request->input('id') != null) {
            $entry = $this->apiCrm->setEntry('AOP_Case_Updates',['name' => $request->input('update')]);
            $idNewEntry = $entry['id'];
            $caseId = $request->input('id');
            $result = $this->apiCrm->setRelationship('AOP_Case_Updates', $idNewEntry, 'case', [$caseId], array());
            return $result;
        }
        
        return false;
    }


}
