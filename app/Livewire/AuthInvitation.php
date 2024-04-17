<?php

namespace App\Livewire;

use App\Models\Invitation;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use HasanAhani\FilamentOtpInput\Components\OtpInput;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AuthInvitation extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Invitation $invitation;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                OtpInput::make('password')
                    ->label('')
                    ->text()
                    ->required()
                    ->markAsRequired(false)
                    ->numberInput(5)
                    ->helperText('Ingresa el código que recibiste por WhatsApp')
                    ->autofocus(),
            ])
            ->statePath('data')
            ->model($this->invitation);
    }

    public function authenticate()
    {
        $inputPassword = str($this->form->getState()['password'])->upper();

        if (! Hash::check($inputPassword, $this->invitation->password)) {
            Notification::make()
                ->title('Código incorrecto')
                ->body('Por favor, verifica el código e inténtalo de nuevo.')
                ->danger()
                ->send();

            $this->form->fill();

            return null;
        }

        request()->session()->put('invitation_code', $this->invitation->code);
        request()->session()->save();

        $event = $this->invitation->event;

        $expirationDate = Carbon::parse($event->date->format('Y-m-d').' '.$event->time)->addDays(2);
        $minutesUntilExpiration = Carbon::now()->diffInMinutes($expirationDate);
        Cookie::queue('invitation_authenticated', true, $minutesUntilExpiration);

        return redirect()->route('event.index', [
            'event' => $event->id,
            'invitation' => $this->invitation->code,
        ]);
    }

    #[Layout('components.layouts.invitation')]
    public function render()
    {
        return view('livewire.auth-invitation');
    }
}
