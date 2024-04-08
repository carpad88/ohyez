import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            screens: {
                'sm': '480px',
            },
            fontFamily: {
                display: [
                    '"Bricolage Grotesque", serif',
                ],
                sans: [
                    'Inter, serif',
                ],
            },
        }
    }
}
