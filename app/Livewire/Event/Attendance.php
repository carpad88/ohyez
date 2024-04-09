<?php

namespace App\Livewire\Event;

use App\Models\Invitation;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Attendance extends Component
{
    public ?Invitation $invitation;

    public $checkedIn = true;

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

        $this->invitation = null;
    }

    public function render(): View
    {
        return view('livewire.event.attendance');
    }
}
