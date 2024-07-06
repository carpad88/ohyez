<div>
    <h1 class="font-bold text-4xl">{{ $invitation->family }}</h1>

    <div class="flex justify-center my-8">
        {!! $qr !!}
    </div>

    @php
        $tables = $invitation->guests->groupBy('table')->sortBy(fn ($group, $key) => $key);
    @endphp

    @if($tables->count() > 1)
        <div class="mb-8">
            <h2 class="text-center text-3xl">
                {{ $invitation->guests->count() }} personas
            </h2>

            <div class="mx-auto w-60 space-y-8 text-left">
                @foreach($tables as $table => $guests)
                    <div class="">
                        @if($table == 0)
                            <h3 class="font-bold text-xl border-b">Sin mesa asignada</h3>
                        @else
                            <h3 class="font-bold text-xl border-b">Mesa {{ $table }}</h3>
                        @endif
                        <ul class="flex flex-wrap gap-3 my-3">
                            @foreach($guests as $guest)
                                <li class="border px-2 py1 rounded">{{ $guest->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="mb-8 text-center">
            <p class="text-2xl">Mesa {{ $invitation->guests->first()->table }}</p>
            <p class="text-3xl font-bold">{{ $invitation->guests->count() }} personas</p>
        </div>
    @endif
</div>
