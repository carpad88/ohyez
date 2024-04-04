<?php

namespace App\Livewire\Event;

use App\Enums\InvitationStatus;
use App\Models\Event;
use App\Models\Invitation;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Component;

class Attendance extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Event $event;

    public ?Invitation $invitation;

    public $checkedIn = true;

    public function table(Table $table): Table
    {
        return $table
            ->relationship(
                fn (): HasMany => $this->event->invitations()
                    ->where('status', '=', InvitationStatus::Confirmed)
                    ->when($this->checkedIn,
                        fn ($query) => $query->whereNotNull('checkedIn'),
                        fn ($query) => $query->whereNull('checkedIn')
                    )
            )
            ->inverseRelationship('invitations')
            ->columns([
                Tables\Columns\TextColumn::make('family')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function validateQRCode($uuid): void
    {
        $this->invitation = Invitation::where('code', $uuid)->first();

        if (! $this->invitation) {
            $this->sendNotification('Código incorrecto', 'El código QR no es válido, intenta con otro.', 'danger');

            return;
        }

        if ($this->invitation->event->date->isPast()) {
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
