<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Event - Lista de invitaciones </title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bricolage+Grotesque:200,300,400,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:200,300,400,600,700,800">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #333;
            /*background-color: #f5f5f5;*/
            margin: 100px 100px 50px 100px;
        }

        @page {
            margin: 0;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background-color: #1e1b4b;
            color: #eab308;
        }

        p, h1, h2, h3, h4, h5, h6, span {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*border: 1px solid #4d4d4d;*/
        }

        th, td {
            padding: 5px;
            /*border: 1px solid #4d4d4d;*/
        }

        h1 {
            font-family: Bricolage Grotesque, sans-serif;
            font-weight: 800 !important;
            line-height: 1;
        }
    </style>
</head>

<body>
<header>
    <table style="padding: 10px 30px 10px;">
        <tbody>
        <tr valign="bottom">
            <td style="width: 100px; padding: 0; font-weight: bold;">
                <img src="{{ public_path('img/ohyez-logo.svg') }}" alt="Ohyez Logo" height="60">
            </td>

          <td style="font-weight: lighter; padding-bottom: 12px;" align="right">
            www.ohyez.app
          </td>
        </tr>
        </tbody>
    </table>
</header>

<!-- Body -->
<div>
  <div style="font-size: 20px; color: #6d6d6d; line-height: 1; font-weight: 200;">
    <span>{{ $event->date->format("d/m/Y") }}</span> –
    <span>{{ \Carbon\Carbon::parse($event->time)->format('H:i') }}</span>
  </div>

  <h1 style="font-size: 48px; font-weight: lighter; margin-bottom: 30px">{{ $event->title }}</h1>

  @foreach($tables as $table => $guests)
    <div style="margin-bottom: 32px">
      <table cellpadding="3">
        <thead>
        <tr style="background-color: #fce7f3;">
          <th colspan="2" align="left" style="font-weight: 700; font-size: 18px;">
            Mesa {{ $table }}
            <span style="color: #848484; font-size: 12px; font-weight: lighter">
                ({{ $guests->count() }} personas)
            </span>
          </th>
        </tr>
        </thead>
        <tbody>
        @foreach($guests as $guest)
          <tr style="border-bottom: 1px solid #fbcfe8; ">
            <td align="center" width="20">
              <div style="width: 20px; height: 20px; border: 1px solid #898989; border-radius: 4px">
              </div>
            </td>
            <td>
              <h3 style="font-family: 'Bricolage Grotesque', serif; font-size: 13px">
                {{ $guest->family }}
              </h3>
              <p style="color: #848484; font-size: 11px">
                {{ $guest->name }}
              </p>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endforeach
</div>

<script type="text/php">
    if (isset($pdf)) {
        $pdf->page_text(490, 760, "Página {PAGE_NUM} de {PAGE_COUNT}", 'Inter', 7, array(0.3, 0.3, 0.3));
    }
</script>
</body>
</html>
