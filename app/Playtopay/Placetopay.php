<?php

namespace App\Playtopay;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Psy\Util\Str;

class Placetopay implements \App\Playtopay\PaymentGatewayContract
{
    public function createSession():array
    {
        $request = $this->makeRequest();
        $response = Http::post(config('playtopay.uri'). '/api/session', $request);

        return $response->json();
    }
    public function makeRequest()
    {
        $request = request();

        return [
            'locale'=> 'es_CO',
            'auth' => $this->makeAuth(),
            'payment' => $this->makePayment($request),
            'allowPartial' => false,
            'expiration' => Carbon::now(new \DateTimeZone('America/Bogota'))->addHour()->toIso8601String(),
            'returnUrl' => config('playtopay.uri'),
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'PlacetoPay Sandbox',
        ];


    }
    public function makeAuth(): array
    {
        $nonce = \Illuminate\Support\Str::random();
        $seed = Carbon::now(new \DateTimeZone('America/Bogota'))->toIso8601String();
        $data =[

                'login' => config('playtopay.login'),
                'tranKey' => base64_encode(sha1($nonce . $seed . config('playtopay.secretKey'),true)),
                'nonce' => base64_encode($nonce),
                'seed' => $seed,

        ];
        //dd($data);
        return $data;
    }
    public function makePayment(Request $request): array
    {

        $reference = $request->get('reference');
        $description = $request->get('description');
        $total = $request->get('total');
        return [

                'reference' => $reference,
                'description' => $description,
                'amount'=> [
                     'currency' => 'USD',
                    'total' => $total,
                ],
            

        ];

    }

}
