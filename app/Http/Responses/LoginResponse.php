<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse extends \Filament\Http\Responses\Auth\LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = auth()->user();

        if ($user->hasRole('customer')) {
            return redirect()->to('/dashboard');
        }

        if ($user->hasRole('super_admin')) {
            return redirect()->to('admin');
        }

        return parent::toResponse($request);
    }
}
