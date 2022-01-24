<?php

namespace App\Providers;

use App\Http\Controllers\PaymentController;
use App\Placetopay\PaymentGatewayContract;
use App\Placetopay\Placetopay;
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
