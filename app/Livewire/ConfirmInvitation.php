<?php

namespace App\Livewire;

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class ConfirmInvitation extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Invitation $invitation;

    public function render()
    {
        return view('livewire.confirm-invitation');
    }

    public function confirm(): Action
    {
        return Action::make('confirm')
            ->outlined()
            ->size('xl')
            ->icon('heroicon-o-user-group')
            ->extraAttributes(['class' => 'py-4 px-6 mt-8'])
            ->visible($this->invitation->status === InvitationStatus::Pending)
            ->modalHeading('Confirmar asistencia')
            ->modalWidth('sm')
            ->label('Confirmar asistencia')
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
                        ->live()
                        ->grouped(),
                    Forms\Components\Fieldset::make('guests')
                        ->disabled(fn (Forms\Get $get) => $get('status') === InvitationStatus::Declined)
                        ->label(fn () => 'Personas ('.count($this->invitation->guests).')')
                        ->columns(['default' => 2])
                        ->schema(fn () => collect($this->invitation->guests)
                            ->map(fn ($guest, $index) => Forms\Components\Toggle::make('guests.'.$guest['id'])
                                ->key($index + 5)
                                ->label($guest['name'])
                                ->default($guest['confirmed'] ?? true)
                            )
                            ->toArray()
                        ),
                ]
            )
            ->action(function (array $data) {
                $this->invitation->update([
                    'status' => $data['status'],
                    'guests' => collect($this->invitation->guests)
                        ->map(fn ($guest) => [
                            'id' => $guest['id'],
                            'name' => $guest['name'],
                            'confirmed' => $data['status'] === InvitationStatus::Confirmed
                                ? $data['guests'][$guest['id']]
                                : false,
                        ])
                        ->toArray(),
                ]);

                $this->dispatch('invitationConfirmed');
            });
    }
}
