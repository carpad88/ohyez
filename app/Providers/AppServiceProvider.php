<?php

namespace App\Providers;

use Filament\Forms;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
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

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');

        Model::unguard();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ?: null;
        });

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
            Js::make('alpine-sort', 'https://cdn.jsdelivr.net/npm/@alpinejs/sort@3.x.x/dist/cdn.min.js'),
        ]);

        FilamentIcon::register([
            'panels::sidebar.group.collapse-button' => 'phosphor-caret-up-duotone',
            'panels::user-menu.profile-item' => 'phosphor-user-circle-duotone',
            'panels::user-menu.logout-button' => 'phosphor-sign-out-duotone',
            'panels::theme-switcher.light-button' => 'phosphor-sun-dim-duotone',
            'panels::theme-switcher.dark-button' => 'phosphor-moon-duotone',
            'panels::theme-switcher.system-button' => 'phosphor-desktop-duotone',
            'actions::action-group' => 'phosphor-dots-three-outline-vertical-duotone',
            'actions::edit-action' => 'phosphor-pencil-duotone',
            'actions::delete-action' => 'phosphor-trash-duotone',
            'actions::force-delete-action' => 'phosphor-trash-duotone',
            'actions::restore-action' => 'phosphor-arrow-u-up-left-duotone',
            'tables::columns.icon-column.false' => 'phosphor-x-circle',
            'tables::columns.icon-column.true' => 'phosphor-check-circle',
        ]);

    }
}
