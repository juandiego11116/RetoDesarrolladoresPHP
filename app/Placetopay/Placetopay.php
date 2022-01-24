<?php

namespace App\Placetopay;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Psy\Util\Str;

class Placetopay implements \App\Placetopay\PaymentGatewayContract
{
    public function createSession(): array
    {
        $request = $this->makeRequest();
        $response = Http::post(config('placetopay.uri'). '/api/session', $request);

        return $response->json();
    }
    public function createSessionConsult(): array
    {
        $request = request();

        $requestId = $request['id_request'];

        $request = ['auth' => $this->makeAuth()];

        $response = Http::post(config('placetopay.uri'). '/api/session/'.$requestId, $request);

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
            'returnUrl' => config('placetopay.uri'),
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'PlacetoPay Sandbox',
        ];
    }
    public function makeAuth(): array
    {
        $nonce = \Illuminate\Support\Str::random();
        $seed = Carbon::now(new \DateTimeZone('America/Bogota'))->toIso8601String();
        $data =[
                'login' => config('placetopay.login'),
                'tranKey' => base64_encode(sha1($nonce . $seed . config('placetopay.secretKey'), true)),
                'nonce' => base64_encode($nonce),
                'seed' => $seed,
        ];
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
