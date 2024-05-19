<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $slug = 'dashboard';

    protected ?string $heading = 'Dashboard';

    protected ?string $subheading = 'Bienvenido de vuelta, $this->user->name!';

    protected static string $view = 'filament.app.pages.dashboard';

    public function getSubheading(): ?string
    {
        return 'Bienvenido, '.auth()->user()->name.'!';
    }
}
