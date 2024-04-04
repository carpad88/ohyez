<div class="px-4">
    <div class="mb-6 flex justify-between items-end text-2xl font-light">
        <p class="">{{ count($invitation->guests) }} personas</p>
        <p class="">Mesa <span class="font-black">{{ $invitation->table }}</span></p>
    </div>
    <div class="flex justify-center mb-8">
        {!! $qr !!}
    </div>
</div>
