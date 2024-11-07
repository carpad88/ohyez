<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as Responsable;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements Responsable
{
    public function toResponse($request): RedirectResponse
    {
        auth()->logout();

        if (config('ohyez.auth_provider') == 'logto') {
            return redirect()->route('auth.sign-out');
        }

        return redirect('/');
    }
}
