<?php

namespace App\Placetopay;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Psy\Util\Str;

class Placetopay implements \App\Placetopay\PaymentGatewayContract
{
    public function createSession(string $reference, int $subtotal): array
    {
        $request = $this->makeRequest($reference, $subtotal);

        $response = Http::post(config('placetopay.uri'). '/api/session', $request);

        return $response->json();
    }

    public function createSessionConsult(string $id_request): array
    {
        $request = ['auth' => $this->makeAuth()];

        $response = Http::post(config('placetopay.uri'). '/api/session/'.$id_request, $request);

        return $response->json();
    }

    public function makeRequest(string $reference, int $subtotal): array
    {
        return [
            'locale'=> 'es_CO',
            'auth' => $this->makeAuth(),
            'payment' => $this->makePayment($reference, $subtotal),
            'allowPartial' => false,
            'expiration' => Carbon::now(new \DateTimeZone('America/Bogota'))->addHour()->toIso8601String(),
            'returnUrl' => route('payment.finish', $reference),
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

    public function makePayment(string $reference, int $subtotal): array
    {
        return [
                'reference' => $reference,
                'description' => 'placetopay',
                'amount'=> [
                     'currency' => 'USD',
                    'total' => $subtotal,
                ],
        ];
    }
}
