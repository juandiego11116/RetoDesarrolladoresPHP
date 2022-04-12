<?php

namespace App\Console\Commands;

use App\Constants\PaymentStatus;
use App\Models\Purchase;
use App\Placetopay\PaymentGatewayContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VerifyPurchaseStatus extends Command
{
    protected $signature = 'purchases:update';

    protected $description = 'Command description';

    public function handle(): int
    {
        $purchases = DB::table('purchases')->join('purchase_product', 'purchase_id', '=', 'id')
            ->select('purchases.id_request', 'purchases.status', 'purchases.deduct_from_stock', 'purchase_product.product_id', 'purchase_product.amount')
            ->where('status', PaymentStatus::PENDING)
            ->get();

        foreach ($purchases as $purchase) {

            $paymentGateway = app()->make(PaymentGatewayContract::class);
            $response = $paymentGateway->createSessionConsult($purchase->id_request);

            if ($purchase->status != $response['status']['status']) {
                DB::table('purchases')
                    ->select('status')
                    ->where('id_request', $response['requestId'])
                    ->update(['status' => $response['status']['status']]);

                if (($response['status']['status'] == PaymentStatus::APPROVED) and ($purchase->deduct_from_stock == false)) {
                    DB::table('purchases')
                        ->select('deduct_from_stock')
                        ->where('id_request', $response['requestId'])
                        ->update(['deduct_from_stock' => true]);

                    $stock_number = DB::table('products')
                        ->select('stock_number')
                        ->where('id', $purchase->product_id)
                        ->get();

                    DB::table('products')
                        ->select('stock_number')
                        ->where('id', $purchase->product_id)
                        ->update(['stock_number' => $stock_number[0]->stock_number - $purchase->amount]);
                }
            }
        }
        return Command::SUCCESS;
    }
}
