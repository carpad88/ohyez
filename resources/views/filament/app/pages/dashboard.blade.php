<x-filament-panels::page>
    <div class="grid grid-cols-3 gap-8">
        @foreach(auth()->user()->events()->get() as $event)
            <div class="border rounded bg-amber-100 p-6">
                <h1>
                    {{ $event->title }}
                </h1>
                <p>{{ $event->tier }}</p>
                <p>Event actions</p>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
