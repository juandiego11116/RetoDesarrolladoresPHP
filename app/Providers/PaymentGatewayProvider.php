<?php

namespace App\Providers;

use App\Http\Controllers\PaymentController;
use App\Placetopay\PaymentGatewayContract;
use App\Placetopay\Placetopay;
use Illuminate\Support\ServiceProvider;

class PaymentGatewayProvider extends ServiceProvider
{

    public function boot() : void
    {
        $this->app->bind(PaymentGatewayContract::class, Placetopay::class);
    }
}
