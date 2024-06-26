import {defineConfig, presetIcons} from 'unocss'

export default defineConfig({
    envMode: 'dev',
    cli: {
        entry: [
            {
                patterns: ['resources/views/**/*.blade.php'],
                outFile: 'resources/css/uno.css',
            },
            {
                patterns: ['resources/views/filament/app/**/*.blade.php'],
                outFile: 'resources/css/filament/app/uno.css',
            }
        ],
    },
    presets: [
        presetIcons({
            cdn: 'https://esm.sh/',
            extraProperties: {
                display: 'inline-block',
            },
        }),
    ]
})
