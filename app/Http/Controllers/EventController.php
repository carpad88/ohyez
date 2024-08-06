<?php

namespace App\Http\Controllers;

use App\Enums\InvitationStatus;
use App\Models\Event;
use App\Models\Invitation;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController
{
    public function preview(Event $event)
    {
        $invitation = null;

        return view('templates.'.$event->template->view, compact('event', 'invitation'));
    }

    public function previewTicket(Event $event)
    {
        $qr = base64_encode(QrCode::backgroundColor(0, 0, 0, 0)->generate($event->uuid));
        $invitation = null;

        $pdf = Pdf::loadView('invitation.tickets', compact('event', 'invitation', 'qr'))
            ->setPaper([0, 0, 198, 612], 'landscape');

        return $pdf->stream('tickets.pdf');
    }

    public function downloadInvitationsList(Event $event)
    {
        $tables = [];

        if (! $event->hasFeaturesWithCode('COM')) {
            $tables = Invitation::where('event_id', $event->id)
                ->join('guests', 'invitations.id', '=', 'guests.invitation_id')
                ->select(['invitations.family', 'guests.name', 'guests.table'])
                ->orderBy('guests.table')
                ->orderBy('invitations.family')
                ->get()
                ->groupBy('table');
        }

        if ($event->hasFeaturesWithCode('COA')) {
            $tables = Invitation::where('event_id', $event->id)
                ->where('status', InvitationStatus::Confirmed)
                ->join('guests', fn ($join) => $join->on('invitations.id', '=', 'guests.invitation_id')
                    ->whereNull('guests.deleted_at')
                    ->where('guests.confirmed', true)
                )
                ->select(['invitations.family', 'guests.name', 'guests.table'])
                ->orderBy('guests.table')
                ->orderBy('invitations.family')
                ->get()
                ->groupBy('table');
        }

        $pdf = Pdf::loadView('event.invitations-list', compact('event', 'tables'))
            ->setOption(['fontDir' => sys_get_temp_dir(), 'isPhpEnabled' => true])
            ->setPaper('Letter');

        return $pdf->stream('invitations.pdf');
    }
}
