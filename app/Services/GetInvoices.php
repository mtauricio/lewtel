<?php


namespace App\Services;


use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\CrmApi;
use Illuminate\Support\Collection;

class GetInvoices
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
    public function execute(string $dni)
    {
        $customers = $this->apiCrm->getEntryList('Accounts', "accounts_cstm.dni_c = '$dni'", '', 0);
        if ($customers['result_count'] > 0) {
            $invoices = array();
            $customerId = $customers['entry_list'][0]['id'];
            $result = Suitecrm::getRelationShipData('Accounts', $customerId, 'aos_invoices', array('id', 'name', 'number', 'quote_date', 'total_amount', 'due_date', 'status'), "aos_invoices.status='Unpaid' and aos_invoices.total_amount != ''", 'due_date asc');
            if (isset($result['entry_list']) && count($result['entry_list']) > 0) {
                $invoices = self::dtoData($result['entry_list']);
            }
            return $this->sortInvoices($invoices);
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

    /**
     * @param array $invoices
     * @return array
     */
    public function sortInvoices(array $invoices): array
    {
        $collection = new Collection($invoices);
        $invoices = $collection->sortBy('due_date');
        return $invoices->values()->all();
    }

}
