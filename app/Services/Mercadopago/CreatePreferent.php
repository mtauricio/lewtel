<?php


namespace App\Services\Mercadopago;

use App\Services\ValidateInvoices;
use Esatic\Suitecrm\Services\CrmApi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;

class CreatePreferent
{

    private ValidateInvoices $validateInvoices;
    // private array $invoicesToPay = array();

    /**
     * ValidateInvoices constructor.
     * @param ValidateInvoices $getInvoices
     */
    public function __construct(ValidateInvoices $validateInvoices)
    {
        $this->validateInvoices = $validateInvoices;
    }


    public function execute(Request $request, $login)
    {
         // SDK de Mercado Pago
    require base_path('/vendor/autoload.php');
    // Agrega credenciales
    SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
    $validateInvoices = [];
    if ($this->validateInvoices->execute($request, $request->input('invoices'))) {
        $validateInvoices = $this->validateInvoices->getInvoicesToPay();
    }
    
        // Crea un objeto de preferencia
        $preference = new Preference();

        foreach ($validateInvoices as $invoice) {
           // Crea un ítem en la preferencia
            $item = new Item();
            $item->id = $invoice["id"];
            $item->title = $invoice["name"];
            $item->description = $invoice["number"];
            $item->quantity = 1;
            $item->currency_id = "ARS";
            $item->unit_price = $invoice["total_amount"];

            $invoices[] = $item;
            }
            if ($login) {
                $preference->back_urls = array(
                    "success" => route('dashboard.approved',['invoices' => $validateInvoices,'statuspay' => 'Approved']),
                    "failure" => route('dashboard.approved',['invoices' => $validateInvoices,'statuspay' => 'failure']),
                    "pending" => route('dashboard.approved',['invoices' => $validateInvoices,'statuspay' => 'pending'])
                );
            } else {
                $preference->back_urls = array(
                    "success" => route('redirect.approved',['dni' => $request->dni,'invoices' => $validateInvoices,'statuspay' => 'Approved']),
                    "failure" => route('redirect.approved',['dni' => $request->dni,'invoices' => $validateInvoices,'statuspay' => 'failure']),
                    "pending" => route('redirect.approved',['dni' => $request->dni,'invoices' => $validateInvoices,'statuspay' => 'pending'])
                );
            }
            
            
            $preference->auto_return = "approved";
        
        $preference->items = $invoices;
        $preference->save();

        return $preference->id;
    }

    
}
