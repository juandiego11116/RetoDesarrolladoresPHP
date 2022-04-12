<?php

namespace App\Http\Controllers;

use App\Constants\PaymentStatus;
use App\Models\Purchase;
use App\Placetopay\PaymentGatewayContract;
use Carbon\Carbon;
use Hamcrest\BaseDescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $reference = (string) Str::random(32);
        $subtotal = $request->input('amount') * $request->input('price');
        $data = [];

        $data[$request['id_product']] = [
            'amount' => $request->input('amount'),
            'price' => $request->input('price'),
            'subtotal' => $subtotal,
        ];

        $paymentGateway = app()->make(PaymentGatewayContract::class);
        $response = $paymentGateway->createSession($reference, $subtotal);



        $purchase = new Purchase();
        $purchase->reference = $reference;
        $purchase->total = $subtotal;
        $purchase->status = PaymentStatus::PENDING;
        $purchase->id_request = $response['requestId'];
        $purchase->deduct_from_stock = false;
        $purchase->save();

        $purchase->products()->attach($data);

        return redirect()->away($response['processUrl']);
    }

    public function finish(Request $request, string $reference): View
    {
        $purchases = DB::table('purchases')
            ->select('id_request', 'total', 'status')
            ->where('reference', $reference)
            ->get();
        $products = DB::table('purchase_product')
            ->join('products', 'purchase_product.product_id', '=', 'products.id')
            ->select('products.id','products.name', 'purchase_product.amount', '')
            ->where('id', '=', $purchases[0]->id_product)
            ->get();


        $id_request = $purchases ;
        $id_request = $id_request->toArray();
        $id_request = $id_request[0];
        $id_request = $id_request->id_request;


        $paymentGateway = app()->make(PaymentGatewayContract::class);
        $response = $paymentGateway->createSessionConsult($purchases->id_request);



        DB::table('purchases')
            ->select('status')
            ->where('id_request', 'LIKE', $response['requestId'])
            ->update(['status' => $response['status']['status']]);
        $stockNumber = DB::table('products')
            ->select('stock_number')
            ->where('id', $request['id_product'])
            ->first();

        if ($response['status']['status'] == PaymentStatus::APPROVED) {
            $stockNumber = $stockNumber->stock_number;
            $amount = $request['amount'];
            $stockNumber = $stockNumber - $amount;
            DB::table('products')
                ->select('stock_number')
                ->where('id', $request['id_product'])
                ->update(['stock_number' => $stockNumber]);
        }

        return view('purchases.finish', compact( , 'price', 'reference', 'nameProduct'));
    }
}
