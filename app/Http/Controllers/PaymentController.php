<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Placetopay\PaymentGatewayContract;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $paymentGateway = app()->make(PaymentGatewayContract::class, $request->only('total', 'reference', 'description'));
        $response = $paymentGateway->createSession();
        $data = [
            'id_product' => $request['id_product'],
            'id_request' => $response['requestId'],
            'price' => $request['price'],
            'amount' => $request['amount'],
            'status' => 'pending',
        ];
        Purchase::create($data);
        return redirect()->away($response['processUrl']);
    }
    public function index(Request $request)
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

    public function update(Request $request)
    {
    }
    public function show(Request $request)
    {
        $paymentGateway = app()->make(PaymentGatewayContract::class, $request->only('id_request'));
        $response = $paymentGateway->createSessionConsult();

        $purchases = Purchase::find($response['requestId']);

        DB::table('purchases')
             ->select('status')
             ->where('id_request', 'LIKE', $response['requestId'])
             ->update(['status' => $response['status']['status']]);

        $purchases = DB::table('purchases')->join('products', 'products.id', '=', 'purchases.id_product')
        ->select('purchases.id', 'purchases.id_product', 'products.name', 'purchases.id_request', 'purchases.price', 'purchases.amount', 'purchases.status')
        ->orderBy('purchases.status', 'asc')
        ->paginate(5);
        $text = trim($request->get('text'));

        return view('purchases.history', compact('purchases', 'text'));
    }

}
