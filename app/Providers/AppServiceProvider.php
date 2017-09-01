<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Payment\PaymentConstance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $currency = strtoupper(PaymentConstance::STIRPE_CURRENCY);
        view()->share('currency', $currency);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
