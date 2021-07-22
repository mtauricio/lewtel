<?php


namespace App\Services;


use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\CrmApi;

class CreateTicket
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
     * @param string $dni
     * @return array
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function execute($status)
    {
        $query = "";
        if ($status != null) {
            $query = "cases.status !='Closed'";
        }
        $account = $this->apiCrm->getEntry(auth()->user()->id_crm, auth()->user()->type_user);
        if (isset($account['entry_list'][0]['name_value_list']['id'])) {
            $tickets = array();
            $customerId = $account['entry_list'][0]['id'];
            $result = Suitecrm::getRelationShipData( auth()->user()->type_user, $customerId, 'cases', array('id','case_number','name','status','description','descripcionn2_c','date_entered'), $query, 'date_entered asc');
            if (isset($result['entry_list']) && count($result['entry_list']) > 0) {
                $tickets = self::dtoData($result['entry_list']);
            }
            return $tickets;
        }
        
        return false;
    }

    public static function dtoData($data): array
    {
        $tickets = array();
        foreach ($data as $item) {
            
            $tickets[] = [
                'id' => $item['name_value_list']['id']['value'],
                'affair' => $item['name_value_list']['name']['value'],
                'number' => $item['name_value_list']['case_number']['value'],
                'status' => $item['name_value_list']['status']['value'],
                'description' => $item['name_value_list']['description']['value'],
                'date_entered' => $item['name_value_list']['date_entered']['value'],
                'secundary_description' => $item['name_value_list']['descripcionn2_c']['value']
            ];
        }
        return $tickets;
    }

    public function showTicket($id)
    {
        $ticket = $this->apiCrm->getEntry($id, 'Cases');

        
        $ticketData = '';
        if (isset($ticket['entry_list'][0]['name_value_list']['id'])) {
            $ticketData = self::dtoData($ticket['entry_list']);
        }
        return $ticketData[0];
    }

}
