<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Logto\Sdk\LogtoClient;

class Authenticate extends Middleware
{
    public function authenticate($request, $guards): void
    {
        if (config('ohyez.auth_provider') == 'logto') {
            $client = app(LogtoClient::class);

            if (! $client->isAuthenticated()) {
                auth()->logout();
                static::redirectUsing(fn () => route('auth.sign-in'));
            }
        }

        $guard = Filament::auth();

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        $user = $guard->user();

        $panel = Filament::getCurrentPanel();

        abort_if(
            $user instanceof FilamentUser ?
                (! $user->canAccessPanel($panel)) :
                (config('app.env') !== 'local'),
            403,
        );

    }

    protected function redirectTo($request): ?string
    {
        return Filament::getLoginUrl();
    }
}
