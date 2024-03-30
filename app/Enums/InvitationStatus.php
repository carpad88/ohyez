<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum InvitationStatus: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Declined = 'declined';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => __('ohyez.invitation.pending'),
            self::Confirmed => __('ohyez.invitation.confirmed'),
            self::Declined => __('ohyez.invitation.declined'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Confirmed => 'success',
            self::Declined => 'danger',

        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Pending => 'heroicon-o-clock',
            self::Confirmed => 'heroicon-o-check',
            self::Declined => 'heroicon-o-x',
        };
    }
}
