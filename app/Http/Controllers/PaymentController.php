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

        $request['reference'] = (string) Str::random(32);
        $price = $request->only('price');
        $amount = $request->only('amount');

        $total = $price['price'] * $amount['amount'];
        $request['total'] = $total;

        $paymentGateway = app()->make(PaymentGatewayContract::class, $request->only('total', 'reference', 'description'));
        $response = $paymentGateway->createSession();

        $stockNumber = DB::table('products')
            ->select('stock_number')
            ->where('id', $request['id_product'])
            ->first();

        $stockNumber = $stockNumber->stock_number;
        $amount = $request['amount'];
        $stockNumber = $stockNumber - $amount;
        DB::table('products')
            ->select('stock_number')
            ->where('id', $request['id_product'])
            ->update(['stock_number' => $stockNumber]);

        $purchase = new Purchase();
        $purchase->id_product = $request['id_product'];
        $purchase->id_request = $response['requestId'];
        $purchase->price = $request['price'];
        $purchase->amount = $request['amount'];
        $purchase->status = PaymentStatus::PENDING;
        $purchase->reference = $request['reference'];
        $purchase->deduct_from_stock = true;

        $purchase->save();
        return redirect()->away($response['processUrl']);
    }

    public function index(Request $request): View
    {
        $text = trim($request->get('text'));
        $purchases = DB::table('purchases')->join('products', 'products.id', '=', 'purchases.id_product')
            ->select('purchases.id', 'purchases.id_product', 'products.name', 'purchases.id_request', 'purchases.price', 'purchases.amount', 'purchases.status')
            ->where('purchases.price', 'LIKE', '%'.$text.'%')
            ->orWhere('products.name', 'LIKE', '%'.$text.'%')
            ->orWhere('purchases.amount', 'LIKE', '%'.$text.'%')
            ->orWhere('purchases.status', 'LIKE', '%'.$text.'%')
            ->orderBy('purchases.status', 'asc')
            ->paginate(5);

        return view('purchases.history', compact('purchases', 'text'));
    }

    public function finish(Request $request, string $reference): View
    {
        //ingresar descuento del profucto segun el estado
        $dataTransaction = DB::table('purchases', )
            ->select('id_request', 'amount', 'id_product', 'price')
            ->where('reference', 'LIKE', $reference)
            ->get();
        $nameProduct = DB::table('products')
            ->select('name')
            ->where('id', '=', $dataTransaction[0]->id_product)
            ->get();
        $nameProduct = $nameProduct[0]->name;
        $amount = $dataTransaction[0]->amount;
        $price = $dataTransaction[0]->price;

        $id_request = $dataTransaction ;
        $id_request = $id_request->toArray();
        $id_request = $id_request[0];
        $id_request = $id_request->id_request;
        $request['id_request'] = $id_request;

        $paymentGateway = app()->make(PaymentGatewayContract::class, $request->only('id_request'));
        $response = $paymentGateway->createSessionConsult();

        $status = $response['status']['status'];

        DB::table('purchases')
            ->select('status')
            ->where('id_request', 'LIKE', $response['requestId'])
            ->update(['status' => $response['status']['status']]);


        return view('purchases.finish', compact('status', 'amount', 'price', 'reference', 'nameProduct'));
    }

    public function history(Request $request): View
    {
        $text = trim($request->get('text'));

        $purchases = DB::table('purchases')->join('products', 'products.id', '=', 'purchases.id_product')
            ->select('purchases.id', 'purchases.id_product', 'products.name', 'purchases.id_request', 'purchases.price', 'purchases.amount', 'purchases.status')
            ->where('purchases.price', 'LIKE', '%'.$text.'%')
            ->orWhere('products.name', 'LIKE', '%'.$text.'%')
            ->orWhere('purchases.amount', 'LIKE', '%'.$text.'%')
            ->orWhere('purchases.status', 'LIKE', '%'.$text.'%')
            ->orderBy('purchases.status', 'asc')
            ->paginate(5);


        for ($i = 0; $i < 5; $i++){

            $value = $purchases[$i]->id_request;
            $request['id_request'] = $value;

            $paymentGateway = app()->make(PaymentGatewayContract::class, $request->only('id_request'));
            $response = $paymentGateway->createSessionConsult();

            DB::table('purchases')
                ->select('status')
                ->where('id_request', 'LIKE', $response['requestId'])
                ->update(['status' => $response['status']['status']]);

        }
        return view('purchases.history', compact('purchases', 'text'));
    }
}
