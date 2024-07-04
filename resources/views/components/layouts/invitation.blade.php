<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    @stack('meta')

    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes __un_qm {
            0% {
                box-shadow: inset 4px 4px #ff1e90, inset -4px -4px #ff1e90
            }
            100% {
                box-shadow: inset 8px 8px #3399ff, inset -8px -8px #3399ff
            }
        }

        .where, .\? {
            animation: __un_qm 0.5s ease-in-out alternate infinite;
        }
    </style>

    @filamentStyles
    @vite('resources/css/templates/' . ($css ?? 'app') . '.css')
</head>

<body class="antialiased">

{{ $slot }}

@livewire('notifications')

@filamentScripts
@vite('resources/js/app.js')

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('counter', () => ({
            targetDate: new Date('{{ $date ?? now()->addDays(7)->format('Y-m-d H:i:s')}}'),
            timeLeft: null,
            intervalId: null,
            calculateTimeLeft() {
                const now = new Date();
                const difference = this.targetDate - now;

                return {
                    days: Math.floor(difference / (1000 * 60 * 60 * 24)).toString().padStart(2, '0'),
                    hours: Math.floor((difference / (1000 * 60 * 60)) % 24).toString().padStart(2, '0'),
                    minutes: Math.floor((difference / 1000 / 60) % 60).toString().padStart(2, '0'),
                    seconds: Math.floor((difference / 1000) % 60).toString().padStart(2, '0')
                };
            },
            init() {
                this.timeLeft = this.calculateTimeLeft();
                if (this.intervalId !== null) clearInterval(this.intervalId);

                this.intervalId = setInterval(() => {
                    this.timeLeft = this.calculateTimeLeft();
                }, 1000);
            }
        }))
    })
</script>
</body>
</html>
