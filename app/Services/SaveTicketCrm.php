<?php


namespace App\Services;


use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\CrmApi;

class SaveTicketCrm
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
        $account = $this->apiCrm->getEntry(auth()->user()->id_crm, auth()->user()->type_user);
        if (isset($account['entry_list'][0]['name_value_list']['id'])) {
            $entry = $this->apiCrm->setEntry('Cases',['name' => $request->input('affair'),'description' => $request->input('description')]);
            
            $idNewEntry = $entry['id'];
            $customerId = $account['entry_list'][0]['id'];
    
            $result = $this->apiCrm->setRelationship('Cases', $idNewEntry, strtolower(auth()->user()->type_user), [$customerId], array());
            return $result;
        }
        
        return false;
    }


}
