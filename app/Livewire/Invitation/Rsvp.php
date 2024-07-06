<?php

namespace App\Livewire\Invitation;

use App\Enums\InvitationStatus;
use App\Models\Guest;
use App\Models\Invitation;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Rsvp extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Invitation $invitation;

    public $status;

    public function mount(Invitation $invitation): void
    {
        $this->invitation = $invitation;
        $this->status = $invitation->status->value;
    }

    #[On('status-updated')]
    public function updateStatus($status): void
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.invitation.rsvp');
    }

    public function confirmAttendance(): Action
    {
        return Action::make('confirmAttendance')
            ->visible($this->invitation->status === InvitationStatus::Pending)
            ->modalHeading('Confirmar asistencia')
            ->modalWidth('sm')
            ->modalSubmitActionLabel('Confirmar')
            ->form(
                fn () => [
                    Forms\Components\TextInput::make('name')
                        ->label('Familia')
                        ->default($this->invitation->family)
                        ->disabled(),
                    Forms\Components\ToggleButtons::make('status')
                        ->label('¿Asistirás al evento?')
                        ->default(InvitationStatus::Confirmed)
                        ->options([
                            'confirmed' => 'Sí podre asistir',
                            'declined' => 'No podre asistir',
                        ])
                        ->colors([
                            'declined' => 'warning',
                            'confirmed' => 'success',
                        ])
                        ->icons([
                            'declined' => 'phosphor-smiley-sad-duotone',
                            'confirmed' => 'phosphor-smiley-duotone',
                        ])
                        ->live()
                        ->grouped(),
                    Forms\Components\Fieldset::make()
                        ->hidden(fn (Forms\Get $get) => $get('status') === InvitationStatus::Declined)
                        ->label(fn () => 'Personas ('.count($this->invitation->guests).')')
                        ->columns(['default' => 2])
                        ->schema(fn () => collect($this->invitation->guests)
                            ->map(fn ($guest) => Forms\Components\Toggle::make('guests.'.$guest->id)
                                ->label($guest->name)
                                ->onIcon('phosphor-check-bold')
                                ->offIcon('phosphor-question-mark-bold')
                                ->onColor('success')
                                ->default($guest->confirmed ?? true)
                            )
                            ->toArray()
                        ),
                ]
            )
            ->action(function (array $data) {
                $this->invitation->update(['status' => $data['status']]);

                if (isset($data['guests'])) {
                    foreach ($data['guests'] as $guestId => $confirmed) {
                        Guest::find($guestId)->update(['confirmed' => $confirmed]);
                    }
                }

                if ($data['status'] === InvitationStatus::Confirmed) {
                    Notification::make()
                        ->title('Invitación confirmada')
                        ->success()
                        ->send();
                } else {
                    Notification::make()
                        ->title('Invitación declinada')
                        ->danger()
                        ->send();
                }

                $this->dispatch('status-updated', status: $data['status']);
            });
    }

    public function showQrCode(): Action
    {
        return Action::make('showQrCode')
            ->modalWidth('sm')
            ->disabled(fn () => ! $this->invitation->allConfirmedGuestsHaveTableAssigned())
            ->modalHeading(false)
            ->modalSubmitAction(fn () => Action::make('download')
                ->extraAttributes(['class' => 'mt-0'])
                ->label('Descargar')
                ->url(fn () => route('event.download', ['invitation' => $this->invitation->uuid]))
                ->openUrlInNewTab()
            )
            ->modalContent(fn ($action) => view('livewire.invitation.qr-code-modal', [
                'qr' => QrCode::size(240)
                    ->eye('circle')
                    ->style('dot', 0.99)
                    ->generate($this->invitation->uuid),
                'invitation' => $this->invitation->load([
                    'guests' => fn ($query) => $query->where([
                        ['confirmed', '=', true],
                        ['table', '>', 0],
                    ]),
                ]),
                'action' => $action,
            ]));
    }
}
