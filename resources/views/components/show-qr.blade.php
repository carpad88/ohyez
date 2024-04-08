<div class="px-4">
    <div class="mb-6 flex justify-between items-end text-2xl font-light">
        <p class="">
            {{ collect($invitation->guests)
                ->filter(fn($guest)=> $guest['confirmed'])
                ->count() }} personas
        </p>
      <p class="">Mesa <span class="font-black">{{ $invitation->table }}</span></p>
    </div>
  <div class="flex justify-center mb-8">
    {!! $qr !!}
    </div>
</div>
