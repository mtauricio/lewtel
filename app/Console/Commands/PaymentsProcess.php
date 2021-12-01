<?php

namespace App\Console\Commands;

use App\Models\Invoices;
use App\Models\Payments;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use MercadoPago\Payment;
use App\Services\SavePayments;
use App\Services\UpdateInvoiceStatus;
use Illuminate\Support\Facades\Log;
use MercadoPago\SDK;

class PaymentsProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(SavePayments $savePayments, UpdateInvoiceStatus $updateInvoiceStatus)
    {
        SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
        $payments = Payments::query()->where('status', '=', 'pending')->get();
        foreach ($payments as $payment) {
            // Log::info($payment->id);
            $paymentResult = Http::withHeaders([ 
                'Authorization' => 'Bearer '.env('MP_ACCESS_TOKEN')
            ])->get('https://api.mercadopago.com/v1/payments/search', [
                'sort' => 'date_created',
                'criteria' => 'desc',
                'external_reference' => $payment->id
            ]);
            // Log::info($paymentResult['results']);
            if ($paymentResult['paging']['total'] > 0) {
                foreach ($paymentResult['results'] as $item) {
                    // Log::info($item['id']);
                    $paymentItem = Payment::get($item['id']);
                    $response = $savePayments->execute($paymentItem);
                    $items = [];
                    if (!isset($paymentItem->additional_info->items)) {
                        $invoices = Invoices::query()->where('paymets_id', '=' ,$payment->id )->get();
                        foreach ($invoices as $invoice) {
                            $items[] = (object) ['id' => $invoice->id_crm_invoice];
                        }
                    }else {
                        $items = $paymentItem->additional_info->items;
                    }
                    $updateInvoiceStatus->execute($items, $paymentItem->status);
                }
            }
        }
        return 0;
    }
}
