@props(['event'])

@push('meta')
    @php
        $content = fluent($event->content);

        $title = $event->event_type === \App\Enums\EventType::Wedding
        ? 'Boda de ' . $content->get('cover.bride') . ' y ' . $content->get('cover.groom')
        : 'Fiesta de XV años de ' . $content->get('cover.fifteen');

        $ogImage = "$event->code/og.jpg";
    @endphp

    <meta name="title" content="{{ $title }}">
    <meta name="description" content="Invitación para la {{ $title }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="Invitación para la {{ $title }}">
    <meta property="og:image" content="{{ Storage::disk('s3-events')->url($ogImage) }}">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta name="twitter:title" content="Invitación para la {{ $title }}">
    <meta name="twitter:description" content="Invitación para la Invitación para la {{ $title }}">
    <meta name="twitter:image" content="{{ Storage::disk('s3-events')->url($ogImage) }}">
    <meta name="twitter:card" content="summary">
@endpush
