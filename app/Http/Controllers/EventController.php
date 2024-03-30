<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController
{
    // add index method
    public function index(Event $event, Invitation $invitation)
    {
        $template = 'templates.'.$event->template->view;

        return view('event.index', compact('event', 'invitation', 'template'));
    }

    public function downloadTickets(Event $event, Invitation $invitation)
    {
        $qr = base64_encode(QrCode::size(150)->generate($invitation->code));

        $pdf = Pdf::loadView('event.tickets', compact('event', 'invitation', 'qr'))
            ->setPaper([0, 0, 375, 590]);

        return $pdf->stream('tickets.pdf');
    }
}
