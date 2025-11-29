<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Wallet\WalletService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(WalletService::class, fn() => new WalletService());
    }

    public function boot(): void
    {
        //
    }
}