<div class="min-h-screen grid grid-cols-[1fr_auto_1fr] grid-rows-[1fr_5rem] p-8 bg-indigo-50">
    <x-templates.og-tags :$event/>

    <style>
        .fi-otp-input {
            text-transform: uppercase;
            font-weight: bold;
            font-family: sans-serif;
            font-size: 1.35rem !important;
            padding: 0.5rem 0 !important;
        }

        .fi-otp-input-container {
            gap: 0.75rem !important;
        }

        .fi-fo-field-wrp-helper-text {
            font-size: 1rem !important;
            margin-top: 0.5rem;
        }
    </style>


    <div class="flex flex-col items-center justify-center col-start-2">
        <div class="w-full">
            <div class="flex justify-center items-center">
                @if($event->logo)
                    <img src="{{ Storage::disk('s3-events')->url($event->logo) }}" alt="Event logo">
                @else
                    <h1 class="text-6xl font-bold">{{ $event->content['cover']['fifteen'] }}</h1>
                @endif
            </div>
            <h2 class="mt-6 z-10 text-xl font-mono text-[#e9ab1c]">{{ $event->date->format('d • m • Y') }}</h2>
        </div>


        <form wire:submit="authenticate" class="flex flex-col items-center py-16 max-w-sm">
            <h2 class="text-3xl font-bold mb-6">
                Cógido de acceso
            </h2>

            {{ $this->form }}

            <button type="submit" class="mt-8 rounded bg-indigo-950 px-4 py-3 text-white text-xl font-bold">
                Ver invitación
            </button>
        </form>
    </div>

    <div class="flex items-center justify-center text-gray-500 space-x-1 font-serif text-xs col-start-2">
        <span>By</span>
        <x-logo class="w-10 h-10 "/>
        <span>© All rights reserved {{ now()->year }}</span>
    </div>

    <x-filament-actions::modals/>
</div>
