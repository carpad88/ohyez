<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ticket -{{ $invitation->uuid ?? $event->title }} </title>

    <style>
        @page {
            margin: 0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Roboto", sans-serif;
            font-size: 12pt;
            color: #7c4985;
            width: 100%;
            height: 100%;
            background-color: #e9e7f1;
        }

        .rotate {
            transform: rotate(-90deg);
            transform-origin: top left;
            position: absolute;
            bottom: 0;
            left: 0;
            font-size: 12pt;
            font-weight: bold;
            color: #000;
        }

        h1 {
            font-size: 20pt;
            font-weight: bold;
            line-height: 1;
            text-transform: capitalize;
        }
    </style>
</head>

<body>

<table cellspacing="0" cellpadding="0" style="width: 100%; height: 100%;">
    <tr>
        <td style="width: 204pt; overflow: hidden">
            <div>
                <img
                    src="{{Storage::disk('s3-templates')->temporaryUrl($event->template->id.'/ticket.jpg', now()->addMinutes(5))}}"
                    alt="bg"
                    style="height: 100%; width: 100%;"
                />
            </div>
        </td>
        <td style="width: 248pt; padding: 15pt;">
            <h1 style="height: 68pt;">{{ $invitation->family ?? 'Nombre del invitado' }}</h1>

            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td style="height: 50pt; font-weight: bold;">
                        <p>{{ $event->date->format('Y / m / d') }}</p>
                        <p>{{ \Carbon\Carbon::parse($event->time)->format('H:i') }} hrs</p>
                    </td>
                </tr>
                <tr>
                    <td style="height: 50pt; font-size: 10pt; vertical-align: bottom">
                        <p style="font-weight: bold">{{ $event->content['locations']['reception']['name'] }}</p>
                        <p>{{ $event->content['locations']['reception']['address'] }}</p>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: auto; padding: 15pt; position: relative;">
            <p class="rotate">
                {{ passwordFromUUID($invitation->uuid ?? '8687a222-b572-475A-b9cF-d7d977607466') }}
            </p>
            <div style="height: 68pt">
                <p style="font-size: 18pt; font-weight: bold">
                    MESA {{ $invitation->guests[0]['table'] ?? 1 }}
                </p>

                <p style="font-size: 16pt; margin-top: 10pt">
                    {{ count($invitation->guests ?? [1,2]) }} personas
                </p>
            </div>

            <div>
                <img src="data:image/png;base64, {!! $qr !!}" alt="qr-code" style="width: 100pt;">
            </div>
        </td>
    </tr>
</table>

{{--<script type="text/php">--}}
{{--    if (isset($pdf)) {--}}
{{--        $pdf->page_text(548, 741, "Página {PAGE_NUM} de {PAGE_COUNT}", 'Roboto', 7, array(0.3, 0.3, 0.3));--}}
{{--    }--}}
{{--</script>--}}

</body>
</html>
