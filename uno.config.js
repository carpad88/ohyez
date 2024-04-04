import {defineConfig, presetIcons} from 'unocss'

export default defineConfig({
    envMode: 'dev',
    cli: {
        entry: {
            patterns: ['resources/views/**/*.blade.php'],
            outFile: 'resources/css/uno.css',
        },
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
