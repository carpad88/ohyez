<?php

namespace App\Providers\Filament;

use App\Http\Middleware\Authenticate;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $filamentAuth = config('ohyez.auth_provider') == 'local';

        return $panel
            ->default()
            ->id('app')
            ->path('')
            ->when($filamentAuth, fn (Panel $panel) => $panel->login())
            ->when($filamentAuth, fn (Panel $panel) => $panel->registration())
            ->when($filamentAuth, fn (Panel $panel) => $panel->emailVerification())
            ->when($filamentAuth, fn (Panel $panel) => $panel->passwordReset())
            ->profile(isSimple: false)
            ->brandLogo(asset('img/ohyez-logo.svg'))
            ->brandLogoHeight('3rem')
            ->defaultThemeMode(ThemeMode::Light)
            ->viteTheme('resources/css/filament/app/theme.css')
//            ->font('Amaranth')
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->pages([
                //
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->topNavigation()
            ->breadcrumbs(false)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
