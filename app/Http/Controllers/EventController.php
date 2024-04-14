<?php

namespace App\Http\Controllers;

use App\Enums\InvitationStatus;
use App\Models\Event;
use App\Models\Invitation;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController
{
    public function index(Event $event, Invitation $invitation)
    {
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

    public function downloadInvitations(Event $event)
    {
        $eventWithInvitations = Event::with([
            'invitations' => fn ($query) => $query->where('status', InvitationStatus::Confirmed)
                ->orderBy('table')
                ->orderBy('family')
                ->select('id', 'event_id', 'family', 'table', 'guests'),
        ])->find($event->id);

        $tables = $eventWithInvitations->invitations->groupBy('table');

        $pdf = Pdf::loadView('event.invitations', compact('event', 'tables'))
            ->setOption(['fontDir' => sys_get_temp_dir(), 'isPhpEnabled' => true])
            ->setPaper('Letter');

        return $pdf->stream('invitations.pdf');
    }
}
