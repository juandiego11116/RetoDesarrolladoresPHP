<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Playtopay\PaymentGatewayContract;
use Illuminate\Http\Request;

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


}
