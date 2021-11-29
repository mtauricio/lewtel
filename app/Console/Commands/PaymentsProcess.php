<?php

namespace App\Console\Commands;

use App\Models\Payments;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use MercadoPago\Payment;
use App\Services\SavePayments;
use App\Services\UpdateInvoiceStatus;

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
        $payments = Payments::query()->where('status', '<>', 'status')->get();
        foreach ($payments as $payment) {
            $paymentResult = Http::get('https://api.mercadopago.com/v1/payments/search?sort=date_created&criteria=desc&external_reference=1234' . $payment->id, []);
            if ($paymentResult->paging->total > 0) {
                foreach ($paymentResult->results as $item) {
                    $paymentItem = new Payment($item);
                    $response = $savePayments->execute($paymentItem);
                    $items = $paymentItem->additional_info->items;
                    $updateInvoiceStatus->execute($items, $paymentItem->status);
                }
            }
        }
        return 0;
    }
}
