<?php

namespace App\Placetopay;

use http\Env\Request;

interface PaymentGatewayContract
{
    public function createSession(string $reference, int $subtotal): array;

    public function createSessionConsult(string $id_request): array;
}
