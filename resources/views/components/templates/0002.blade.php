@props(['event', 'invitation'])

<div class="h-full bg-red-400 p-4 text-center space-y-8">
    <h1 class="text-3xl font-bold">
        {{ $event->title }}
    </h1>
    <h2 class="text-xl">
        {{ $invitation->family ?? 'Familia' }}
    </h2>

    @livewire('confirm-invitation', ['invitation' => $invitation])

    @livewire('show-qr-code', ['invitation' => $invitation])
</div>
