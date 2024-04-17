<?php

namespace App\Livewire\Event;

use App\Models\Invitation;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Attendance extends Component
{
    public ?Invitation $invitation;

    public $checkedIn = true;

    #[On('resetInvitation')]
    public function resetInvitation(): void
    {
        $this->invitation = null;
    }

    public function validateQRCode($uuid): void
    {
        $this->invitation = Invitation::where('code', $uuid)->first();

        if (! $this->invitation) {
            $this->sendNotification('Código incorrecto', 'El código QR no es válido, intenta con otro.', 'danger');

            return;
        }

        if ($this->invitation->event->date->addDays(2)->isPast()) {
            $this->sendNotification('Evento pasado', 'La invitación que intentas escanear es de un evento que ya pasó.', 'warning');

            return;
        }

        if ($this->invitation->checkedIn) {
            $this->sendNotification('Código registrado', 'Este código ya fue escaneado, intenta con otro.', 'warning');
        }
    }

    public function checkIn(): void
    {
        $event = $this->invitation->event;
        $eventDateTime = Carbon::parse($event->date->format('Y-m-d').' '.$event->time);

        if (now()->lessThan($eventDateTime)) {
            $this->sendNotification(
                'Simulación de check-in exitoso.',
                'El evento aún no inicia, por lo que este check-in es simulado.',
                'warning'
            );

            return;
        }

        $this->invitation->update([
            'checkedIn' => now(),
        ]);

        $this->sendNotification('Check-in exitoso', 'La invitación ya quedo registrada', 'success');
        $this->dispatch('checkInCompleted');
    }

    private function sendNotification($title, $body, $type): void
    {
        Notification::make()
            ->title($title)
            ->body($body)
            ->$type()
            ->send();

        $this->resetInvitation();
    }

    public function render(): View
    {
        return view('livewire.event.attendance');
    }
}
