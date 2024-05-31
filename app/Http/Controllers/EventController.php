<?php

namespace App\Http\Controllers;

use App\Enums\InvitationStatus;
use App\Models\Event;
use App\Models\Invitation;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController
{
    public function index(Invitation $invitation)
    {
        $event = $invitation->event;
        $template = 'templates.'.$event->template->view;

        return view('event.index', compact('event', 'invitation', 'template'));
    }

    public function downloadTickets(Event $event, Invitation $invitation)
    {
        $qr = base64_encode(QrCode::size(200)->generate($invitation->code));

        $pdf = Pdf::loadView('event.tickets', compact('event', 'invitation', 'qr'))
            ->setPaper([0, 0, 375, 590]);

        return $pdf->stream('tickets.pdf');
    }

    public function preview(Event $event)
    {
        $template = 'templates.'.$event->template->view;

        return view('event.index', compact('event', 'template'));
    }

    public function downloadInvitationsList(Event $event)
    {
        $tables = Invitation::where('event_id', $event->id)
            ->where('status', InvitationStatus::Confirmed)
            ->join('guests', 'invitations.id', '=', 'guests.invitation_id')
            ->select(['invitations.family', 'guests.name', 'guests.table'])
            ->orderBy('guests.table')
            ->orderBy('invitations.family')
            ->get()
            ->groupBy('table');

        $pdf = Pdf::loadView('event.invitations', compact('event', 'tables'))
            ->setOption(['fontDir' => sys_get_temp_dir(), 'isPhpEnabled' => true])
            ->setPaper('Letter');

        return $pdf->stream('invitations.pdf');
    }
}
