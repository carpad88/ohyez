<div>
    @if ($this->confirm()->isVisible())
        {{ $this->confirm() }}
    @endif

    <x-filament-actions::modals />
</div>
