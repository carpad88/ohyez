<?php

namespace App\Providers;

use App\Services\Logto\LogtoAuthService;
use Illuminate\Support\ServiceProvider;
use Logto\Sdk\LogtoClient;

class LogtoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: LogtoClient::class,
            concrete: fn () => LogtoAuthService::run()
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
