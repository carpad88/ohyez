@props(['event'])

@push('meta')
    @php
        $content = fluent($event->content);

        $title = $event->event_type === \App\Enums\EventType::Wedding
        ? 'Boda de ' . $content->get('cover.bride') . ' y ' . $content->get('cover.groom')
        : 'Fiesta de XV años de ' . $content->get('cover.fifteen');
    @endphp

    <meta name="title" content="{{ $title }}">
    <meta name="description" content="Invitación para la {{ $title }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="Invitación para la {{ $title }}">
    {{--    TODO: Change the image path to the correct one--}}
    <meta property="og:image" content="{{ config('app.url') }}//og-xv-renata.jpg">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta name="twitter:title" content="Invitación para la {{ $title }}">
    <meta name="twitter:description" content="Invitación para la Invitación para la {{ $title }}">
    {{--    TODO: Change the image path to the correct one--}}
    <meta name="twitter:image" content="{{ config('app.url') }}/img/og-xv-renata.jpg">
    <meta name="twitter:card" content="summary">
@endpush
