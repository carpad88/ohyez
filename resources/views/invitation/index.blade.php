<x-layouts.invitation>
    @push('meta')
        <meta name="title" content="Mis XV años :: Renata">
        <meta name="description" content="Invitación para la fiesta de XV años de Renata">
        <meta property="og:title" content="Mis XV años :: Renata">
        <meta property="og:description" content="Invitación para la fiesta de XV años de Renata">
        <meta property="og:image" content="{{ config('app.url') }}/img/og-xv-renata.jpg">
        <meta property="og:url" content="{{ config('app.url') }}">
        <meta name="twitter:title" content="Mis XV años :: Renata">
        <meta name="twitter:description" content="Invitación para la fiesta de XV años de Renata">
        <meta name="twitter:image" content="{{ config('app.url') }}/img/og-xv-renata.jpg">
        <meta name="twitter:card" content="summary">
    @endpush

    <div class="flex justify-center items-center w-screen min-h-screen bg-indigo-950">
        <div
            class="bg-rose-100 min-h-screen w-full overflow-auto sm:min-h-max sm:max-w-sm sm:max-h-[748px] sm:border-[10px] sm:rounded-3xl sm:border-black">
            <x-dynamic-component
                :component="$template"
                :event="$event"
                :invitation="$invitation ?? null"
            />
        </div>
    </div>
</x-layouts.invitation>
