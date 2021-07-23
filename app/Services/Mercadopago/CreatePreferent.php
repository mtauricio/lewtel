<?php


namespace App\Services\Mercadopago;

use App\Models\Payments;
use App\Services\SaveInvoices;
use App\Services\ValidateInvoices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Entity;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;

class CreatePreferent
{

    private ValidateInvoices $validateInvoices;
    private SaveInvoices $saveInvoices;
    // private array $invoicesToPay = array();

    /**
     * ValidateInvoices constructor.
     * @param ValidateInvoices $validateInvoices
     * @param SaveInvoices $saveInvoices
     */
    public function __construct(ValidateInvoices $validateInvoices, SaveInvoices $saveInvoices)
    {
        $this->validateInvoices = $validateInvoices;
        $this->saveInvoices = $saveInvoices;
    }


    /**
     * @param Request $request
     * @param $login
     * @return Preference
     * @throws \Exception
     */
    public function execute(Request $request, $login): Preference
    {
        $validateInvoices = [];
        if ($this->validateInvoices->execute($request, $request->input('invoices'))) {
            $validateInvoices = $this->validateInvoices->getInvoicesToPay();
        }

        $invoices = [];
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

        $payment = new Payments();
        $payment->save();
        $this->saveInvoices->execute($payment, $invoices);

        $preference = new Preference();
        if ($login) {
            $preference->back_urls = array(
                "success" => route('dashboard.approved', ['invoices' => $validateInvoices, 'statuspay' => 'Approved']),
                "failure" => route('dashboard.approved', ['invoices' => $validateInvoices, 'statuspay' => 'failure']),
                "pending" => route('dashboard.approved', ['invoices' => $validateInvoices, 'statuspay' => 'pending'])
            );
        } else {
            $preference->back_urls = array(
                "success" => route('redirect.approved', ['dni' => $request->dni, 'invoices' => $validateInvoices, 'statuspay' => 'Approved']),
                "failure" => route('redirect.approved', ['dni' => $request->dni, 'invoices' => $validateInvoices, 'statuspay' => 'failure']),
                "pending" => route('redirect.approved', ['dni' => $request->dni, 'invoices' => $validateInvoices, 'statuspay' => 'pending'])
            );
        }

        $preference->auto_return = "approved";
        $preference->items = $invoices;
        $preference->external_reference = $payment->id;
        $preference->save();
        $payment->preference_id = $preference->id;
        $payment->save();
        // Log::info(print_r($preference, true));
        // Log::info(json_encode($preference));
        // Log::info($preference->id);
        return $preference;
    }


}
