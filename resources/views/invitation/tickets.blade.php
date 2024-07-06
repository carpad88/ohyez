<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ticket -{{ $invitation->uuid }} </title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #333;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url("{{ public_path('/img/ticket-1.jpg') }}");
        }

        @page {
            margin: 0;
        }

        .content {
            padding: 330px 48px 100px 48px;
        }

        h1 {
            font-size: 30px;
            font-weight: bold;
            margin: 0 0 32px;
            line-height: 1;
            color: #fb7185;
        }
    </style>
</head>
<body class="bg">
<!-- Body -->
<div class="content">
    {{--    <h1>--}}
    {{--        {{ $event->title }}--}}
    {{--    </h1>--}}

    {{--    <h2>--}}
    {{--        @php--}}
    {{--            $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);--}}
    {{--        @endphp--}}
    {{--        <p>{{ $formatter->format($event->date) }}</p>--}}
    {{--    </h2>--}}

    <h1>{{ $invitation->family }}</h1>
    {{--    <p>--}}
    {{--        {{ count($invitation->guests) }} personas--}}
    {{--    </p>--}}
    {{--    <ul>--}}
    {{--        @foreach($invitation->guests as $guest)--}}
    {{--            <li>{{ $guest['name'] }}</li>--}}
    {{--        @endforeach--}}
    {{--    </ul>--}}

    <img src="data:image/png;base64, {!! $qr !!}" alt="qr-code" s>

    <div style="float: right; height: 200px; text-align: right; color: #666;">
        <div style="height: 140px;">
            <p style="font-size: 36px;  font-weight: bold; margin: 0;">
                {{ passwordFromUUID($invitation->uuid) }}
            </p>
        </div>

        <div>
            <p style="font-size: 48px; margin: 0; padding: 0; font-weight: bold; line-height: 1">
                {{ $invitation->table }}
            </p>
            <p style="margin: 0;">MESA</p>
        </div>
    </div>


    {{--    <div>--}}
    {{--        <p>Salón de eventos #1453</p>--}}
    {{--        <p>Colonia Centro</p>--}}
    {{--    </div>--}}

    {{--    <div>--}}
    {{--        <p>Este ticket es personal e intransferible</p>--}}
    {{--        <p>Presenta este ticket en la entrada del evento</p>--}}
    {{--    </div>--}}
</div>

{{--<script type="text/php">--}}
{{--    if (isset($pdf)) {--}}
{{--        $pdf->page_text(548, 741, "Página {PAGE_NUM} de {PAGE_COUNT}", 'Roboto', 7, array(0.3, 0.3, 0.3));--}}
{{--    }--}}
{{--</script>--}}

</body>
</html>
