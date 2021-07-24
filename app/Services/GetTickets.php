<?php


namespace App\Services;


use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\CrmApi;

class GetTickets
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
            $query = "cases.state !='Closed'";
        }
        $account = $this->apiCrm->getEntry(auth()->user()->id_crm, 'Accounts');
        if (isset($account['entry_list'][0]['name_value_list']['id'])) {
            $tickets = array();
            $customerId = $account['entry_list'][0]['id'];
            $result = Suitecrm::getRelationShipData('Accounts', $customerId, 'cases', array('id','case_number','name','status','state','description','descripcionn2_c','date_entered'), $query, 'date_entered asc');
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
        $status = "";
        foreach ($data as $item) {
            if ($item['name_value_list']['state']['value'] == "Open") {
                $status = "Abierto";
            }elseif ($item['name_value_list']['state']['value'] == "Closed") {
                $status = "Cerrado";
            }else{
                $status = $item['name_value_list']['state']['value'];
            }
            
            $tickets[] = [
                'id' => $item['name_value_list']['id']['value'],
                'affair' => $item['name_value_list']['name']['value'],
                'number' => $item['name_value_list']['case_number']['value'],
                'status' => $status,
                'description' => $item['name_value_list']['description']['value'],
                'assigned_user_id' => isset($item['name_value_list']['assigned_user_id']) ? $item['name_value_list']['assigned_user_id']['value'] : "",
                'date_entered' => $item['name_value_list']['date_entered']['value'],
                // 'secundary_description' => $item['name_value_list']['descripcionn2_c']['value']
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

    public function showTicketUpdates($id)
    {
       
        $result = Suitecrm::getRelationShipData('Cases', $id, 'aop_case_updates', array('id','name','date_entered'), "aop_case_updates.internal != 1", 'date_entered asc');
        if (isset($result['entry_list']) && count($result['entry_list']) > 0) {
            $updates = array();
            foreach ($result['entry_list'] as $item) {
                
                $updates[] = [
                    'id' => $item['name_value_list']['id']['value'],
                    'name' => $item['name_value_list']['name']['value'],
                    'date_entered' => $item['name_value_list']['date_entered']['value'],
                ];
            }
            return $updates;
        }
     
    }

}
