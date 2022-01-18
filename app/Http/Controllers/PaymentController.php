<?php

namespace App\Http\Controllers;

use App\Playtopay\PaymentGatewayContract;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function store(Request $request)
    {

        $paymentGateway = app()->make(PaymentGatewayContract::class, $request->only('total', 'reference', 'description'));
        $response = $paymentGateway->createSession();

        return redirect()->away($response['processUrl']);
    }
    public function index(Request $request){

    }

}
