<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvitationController
{
    public function view(Invitation $invitation)
    {
        $event = $invitation->event;
        $template = 'templates.'.$event->template->view;

        return view('invitation.index', compact('event', 'invitation', 'template'));
    }

    public function downloadTickets(Invitation $invitation)
    {
        $event = $invitation->event;
        $qr = base64_encode(QrCode::size(200)->generate($invitation->uuid));

        $pdf = Pdf::loadView('invitation.tickets', compact('event', 'invitation', 'qr'))
            ->setPaper([0, 0, 375, 590]);

        return $pdf->stream('tickets.pdf');
    }
}
