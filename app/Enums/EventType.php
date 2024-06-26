<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EventType: string implements HasColor, HasLabel
{
    case Wedding = 'wedding';
    case XV = 'xv';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Wedding => __('ohyez.wedding'),
            self::XV => __('ohyez.xv'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Wedding => 'info',
            self::XV => 'warning',
        };
    }
}
