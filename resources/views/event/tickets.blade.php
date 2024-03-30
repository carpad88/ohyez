<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ticket -{{ $invitation->code }} </title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #333;
        }
        @page {
            margin: 24px;
        }
    </style>
</head>
<body>
<!-- Body -->
<div class="content">
    <h1>
        {{ $event->title }}
    </h1>

    <h2>
        @php
            $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        @endphp
        <p>{{ $formatter->format($event->date) }}</p>
    </h2>

    <p>{{ $invitation->family }}</p>
    <p>
        {{ count($invitation->guests) }} personas
    </p>
    <ul>
        @foreach($invitation->guests as $guest)
            <li>{{ $guest['name'] }}</li>
        @endforeach
    </ul>


    <p style="text-transform: uppercase">{{ explode('-', $invitation->code)[0] }}</p>
    <p>Mesa {{ $invitation->table }}</p>
    <img src="data:image/png;base64, {!! $qr !!}" alt="qr-code">

    <div>
        <p>Salón de eventos #1453</p>
        <p>Colonia Centro</p>
    </div>

    <div>
        <p>Este ticket es personal e intransferible</p>
        <p>Presenta este ticket en la entrada del evento</p>
    </div>
</div>

<script type="text/php">
    if (isset($pdf)) {
        $pdf->page_text(548, 741, "Página {PAGE_NUM} de {PAGE_COUNT}", 'Roboto', 7, array(0.3, 0.3, 0.3));
    }
</script>

</body>
</html>
