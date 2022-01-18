<?php

namespace App\Providers;

use App\Http\Controllers\PaymentController;
use App\Playtopay\PaymentGatewayContract;
use App\Playtopay\Placetopay;
use Illuminate\Support\ServiceProvider;

class PaymentGatewayProvider extends ServiceProvider
{


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PaymentGatewayContract::class, Placetopay::class);
    }
}
