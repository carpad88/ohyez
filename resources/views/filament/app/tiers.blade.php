<div class="grid grid-cols-3 gap-6">
    @foreach($tiers as $tier)
        <a
            href="{{ route('checkout', ['product' => $tier->stripe_id]) }}"
            class="border p-6 rounded"
        >
            <h2>
                Plan {{ $tier['name'] }}
            </h2>
            <p>{{ \Illuminate\Support\Number::currency($tier->default_price_amount/100) }}</p>
        </a>
    @endforeach

    <div class="text-center">
        Ver todas las características
    </div>
</div>
