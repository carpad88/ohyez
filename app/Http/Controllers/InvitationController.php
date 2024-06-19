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

        return view('templates.'.$event->template->view, compact('event', 'invitation'));
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
