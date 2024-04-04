<?php

namespace App\Livewire;

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShowQrCode extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Invitation $invitation;

    public $listeners = ['invitationConfirmed' => '$refresh'];

    public function render()
    {
        return view('livewire.show-qr-code');
    }

    public function showQrCode(): Action
    {
        return Action::make('showQrCode')
            ->label('Ver boletos')
            ->visible($this->invitation->status === InvitationStatus::Confirmed)
            ->modalWidth('sm')
            ->modalHeading($this->invitation->family)
            ->modalSubmitAction(fn () => Action::make('download')
                ->url(fn () => route('event.download', [
                    'event' => $this->invitation->event->id,
                    'invitation' => $this->invitation->code,
                ]))
                ->openUrlInNewTab()
            )
            ->modalContent(fn ($action) => view('components.show-qr', [
                'qr' => QrCode::size(200)
                    ->eye('circle')
                    ->style('dot', 0.95)
                    ->generate($this->invitation->code),
                'invitation' => $this->invitation,
                'action' => $action,
            ]));
    }
}
