import {defineConfig, presetUno} from 'unocss'

export default defineConfig({
    cli: {
        entry: {
            patterns: ['resources/views/**/*.blade.php'],
            outFile: 'resources/css/uno.css',
        },
    },
    envMode: 'dev',
    presets: [
        presetUno()
    ]
})
