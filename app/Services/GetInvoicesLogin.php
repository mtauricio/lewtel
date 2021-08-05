<?php


namespace App\Services;


use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\CrmApi;

class GetInvoicesLogin
{

    private CrmApi $apiCrm;

    /**
     * GetInvoices constructor.
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
            $query = "";
        } else {
            $query = "and aos_invoices.status ='Unpaid'";
        }
        $account = $this->apiCrm->getEntry(auth()->user()->id_crm, auth()->user()->type_user);
        if (isset($account['entry_list'][0]['name_value_list']['id'])) {
            $invoices = array();
            $customerId = $account['entry_list'][0]['id'];
            $result = Suitecrm::getRelationShipData(auth()->user()->type_user, $customerId, 'aos_invoices', array('id', 'name', 'number', 'quote_date', 'total_amount', 'due_date', 'status'), "aos_invoices.total_amount != '' $query", 'due_date asc');
            if (isset($result['entry_list']) && count($result['entry_list']) > 0) {
                $invoices = self::dtoData($result['entry_list']);
            }
            return $invoices;
        }

        return array();
    }

    public static function dtoData($data): array
    {
        $invoices = array();
        foreach ($data as $item) {

            $invoices[] = [
                'id' => $item['name_value_list']['id']['value'],
                'name' => $item['name_value_list']['name']['value'],
                'number' => $item['name_value_list']['number']['value'],
                'quote_date' => $item['name_value_list']['quote_date']['value'],
                'total_amount' => round($item['name_value_list']['total_amount']['value']),
                'due_date' => $item['name_value_list']['due_date']['value'],
                'status' => $item['name_value_list']['status']['value']
            ];
        }
        return $invoices;
    }

}
