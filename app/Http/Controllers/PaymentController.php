<?php

namespace App\Http\Controllers;

use App\Constants\PaymentStatus;
use App\Models\Purchase;
use App\Placetopay\PaymentGatewayContract;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $reference = (string) Str::random(32);
        $data = [];

        foreach (Cart::content() as $product) {
            $data[$product->id] = [
                'amount' => $product->qty,
                'price' => (float) $product->price,
                'subtotal' => (float) $product->price * $product->qty,
            ];
        }

        $paymentGateway = app()->make(PaymentGatewayContract::class);
        $response = $paymentGateway->createSession($reference, $request->total);

        $purchase = new Purchase();
        $purchase->reference = $reference;
        $purchase->total = $request->total;
        $purchase->status = PaymentStatus::PENDING;
        $purchase->id_request = $response['requestId'];
        $purchase->deduct_from_stock = false;
        $purchase->save();

        $purchase->products()->attach($data);
        Cart::destroy();

        return redirect()->away($response['processUrl']);
    }

    public function finish(Request $request, string $reference): View
    {
        $purchases = DB::table('purchases')
            ->select('id', 'id_request', 'total', 'status', 'deduct_from_stock')
            ->where('reference', $reference)
            ->get();

        $products = DB::table('purchase_product')
            ->join('products', 'purchase_product.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', 'purchase_product.amount', 'purchase_product.subtotal', 'purchase_product.price', 'products.stock_number')
            ->where('purchase_id', $purchases[0]->id)
            ->get();

        $paymentGateway = app()->make(PaymentGatewayContract::class);
        $response = $paymentGateway->createSessionConsult($purchases[0]->id_request);

        DB::table('purchases')
            ->select('status')
            ->where('id_request', 'LIKE', $response['requestId'])
            ->update(['status' => $response['status']['status']]);

        if (($response['status']['status'] == PaymentStatus::APPROVED) and ($purchases[0]->deduct_from_stock == false)) {
            $i = 0;
            foreach ($products as $product) {
                DB::table('products')
                    ->select('stock_number')
                    ->where('id', $request['id_product'])
                    ->update(['stock_number' => $product[$i]->stock_number - $product[$i]->amount]);
                $i++;
            }
            DB::table('purchases')
                ->select('deduct_from_stock')
                ->where('id_request', $response['requestId'])
                ->update(['deduct_from_stock' => true]);
        }
        return view('purchases.finish', compact('products', 'purchases', 'reference'));
    }

    public function storeAgain(Request $request): RedirectResponse
    {
        $reference = (string) Str::random(32);

        $datas = DB::table('purchase_product')->join('products', 'products.id', '=', 'purchase_product.product_id')
            ->select('products.id', 'purchase_product.amount', 'products.price')
            ->where('purchase_id', $request->id_purchase)
            ->get();
        $total = 0;

        foreach ($datas as $data) {
            $products[$data->id] = [
                'amount' => $data->amount,
                'price' => (float) $data->price,
                'subtotal' => (float) $data->price * $data->amount,
            ];
            $data->subtotal = $data->amount * $data->price;
            $total = $total + $data->subtotal;
        }

        $paymentGateway = app()->make(PaymentGatewayContract::class);
        $response = $paymentGateway->createSession($reference, $total);

        $purchase = new Purchase();
        $purchase->reference = $reference;
        $purchase->total = $total;
        $purchase->status = PaymentStatus::PENDING;
        $purchase->id_request = $response['requestId'];
        $purchase->deduct_from_stock = false;
        $purchase->save();

        $purchase->products()->attach($products);

        return redirect()->away($response['processUrl']);
    }
}
