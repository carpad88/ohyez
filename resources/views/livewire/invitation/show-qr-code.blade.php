<div>
    @if ($this->showQrCode()->isVisible())
        {{ $this->showQrCode() }}
    @endif

    <x-filament-actions::modals />
</div>
