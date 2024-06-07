<div class="grid grid-cols-3 gap-6">
    @foreach($tiers as $tier)
        <a href="{{ route('checkout', ['priceId' => $tier['priceId']]) }}" class="border p-6 rounded">
            <h2>
                Plan {{ $tier['name'] }}
            </h2>
        </a>
    @endforeach

    <div class="text-center">
        Ver todas las características
    </div>
</div>
