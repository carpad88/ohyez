<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ohyez</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    @filamentStyles
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center bg-indigo-950">
<x-logo class="logo text-yellow-500"/>

@livewire('notifications')

@filamentScripts
@vite('resources/js/app.js')
</body>
</html>
