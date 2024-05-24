<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.event_types', ['wedding', 'xv', 'birthday']);
        $this->migrator->add('general.tiers', config('ohyez.tiers'));
    }
};
