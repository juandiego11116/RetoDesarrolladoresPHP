<?php

namespace App\Placetopay;

use http\Env\Request;

interface PaymentGatewayContract
{
    public function createSession(): array;

    public function createSessionConsult(): array;
}
