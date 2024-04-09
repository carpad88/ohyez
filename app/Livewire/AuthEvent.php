<?php

namespace App\Livewire;

use App\Models\Event;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use HasanAhani\FilamentOtpInput\Components\OtpInput;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AuthEvent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Event $event;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                OtpInput::make('event_id')
                    ->label('ID del evento')
                    ->text()
                    ->required()
                    ->markAsRequired(false)
                    ->numberInput(6)
                    ->autofocus(),
                OtpInput::make('password')
                    ->label('Clave de acceso')
                    ->text()
                    ->required()
                    ->markAsRequired(false)
                    ->numberInput(5),
            ])
            ->statePath('data')
            ->model($this->event);
    }

    public function authenticate()
    {
        $inputEventID = strtoupper($this->form->getState()['event_id']);
        $inputPassword = str($this->form->getState()['password'])->upper();

        if ($this->event->uuid !== $inputEventID || ! Hash::check($inputPassword, $this->event->password)) {
            Notification::make()
                ->title('Acceso incorrecto')
                ->body('El ID del evento o la clave de acceso son incorrectos.')
                ->danger()
                ->send();

            $this->form->fill();

            return null;
        }

        Filament::auth()->loginUsingId(4);
        session()->regenerate();

        return redirect('/admin/events/'.$this->event->id.'/attendance');
    }

    #[Layout('components.layouts.invitation')]
    public function render()
    {
        return view('livewire.auth-event');
    }
}
