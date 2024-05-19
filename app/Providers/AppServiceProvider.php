<?php

namespace App\Providers;

use Filament\Forms;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');

        Model::unguard();

        Forms\Components\Select::configureUsing(function (Forms\Components\Select $entry): void {
            $entry->native(false);
        });

        Tables\Filters\SelectFilter::configureUsing(function (Tables\Filters\SelectFilter $filter): void {
            $filter->native(false);
        });

        FilamentAsset::register([
            Js::make('qr-scanner', asset('js/qr-scanner.umd.min.js')),
            Js::make('qr-scanner-worker', asset('js/qr-scanner-worker.min.js'))
                ->module(),
        ]);

    }
}
