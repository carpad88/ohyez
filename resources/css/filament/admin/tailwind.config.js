import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Admin/**/*.php',
        './resources/views/filament/admin/**/*.blade.php',
        './resources/views/filament/app/forms/components/templates.blade.php',
        './resources/views/filament/app/resources/event/pages/manage-tables.blade.php',
        './resources/views/livewire/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
