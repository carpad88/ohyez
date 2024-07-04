import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import {globSync} from "glob";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...globSync('resources/css/templates/*.css'),
                'resources/css/filament/admin/theme.css',
                'resources/css/filament/app/theme.css'
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
            detectTls: true
        }),
    ],
});
