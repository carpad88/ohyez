<?php

namespace App\Http\Responses;

use App\Filament\App\Resources\EventResource;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse extends \Filament\Http\Responses\Auth\LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = auth()->user();

        if ($user->hasRole('customer')) {
            return redirect(EventResource::getUrl());
        }

        if ($user->hasRole('super_admin')) {
            return redirect('/admin');
        }

        return parent::toResponse($request);
    }
}
