<?php

namespace App\Providers;

use Filament\Forms\Components\Select;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');

        Model::unguard();

        Select::configureUsing(function (Select $entry): void {
            $entry->native(false);
        });

        FilamentAsset::register([
            Js::make('qr-scanner', asset('js/qr-scanner.umd.min.js')),
            Js::make('qr-scanner-worker', asset('js/qr-scanner-worker.min.js'))
                ->module(),
        ]);
    }
}
