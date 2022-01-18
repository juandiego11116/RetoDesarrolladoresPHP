<?php
namespace App\Playtopay;

interface PaymentGatewayContract
{
    public function createSession():array;

}
