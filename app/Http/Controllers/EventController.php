<?php

namespace App\Http\Controllers;

use App\Enums\InvitationStatus;
use App\Models\Event;
use App\Models\Invitation;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController
{
    public function preview(Event $event)
    {
        $invitation = null;

        return view('templates.'.$event->template->view, compact('event', 'invitation'));
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

        $pdf = Pdf::loadView('event.invitations-list', compact('event', 'tables'))
            ->setOption(['fontDir' => sys_get_temp_dir(), 'isPhpEnabled' => true])
            ->setPaper('Letter');

        return $pdf->stream('invitations.pdf');
    }
}
