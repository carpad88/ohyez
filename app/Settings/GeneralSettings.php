<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public array $event_types;

    public array $tiers;

    public static function group(): string
    {
        return 'general';
    }
}
