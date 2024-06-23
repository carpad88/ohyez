<?php

namespace App\Actions\Stripe;

use App\Models\Product;
use Filament\Notifications\Notification;
use Laravel\Cashier\Cashier;

class SyncProducts
{
    public function handle(): void
    {
        collect(Cashier::stripe()
            ->products
            ->all([
                'expand' => ['data.default_price'],
            ]))
            ->each(function ($product) {
                Product::updateOrCreate([
                    'stripe_id' => $product->id,
                ], [
                    'name' => $product->name,
                    'description' => $product->description,
                    'metadata' => $product->metadata,
                    'active' => $product->active,
                    'default_price_id' => $product->default_price->id,
                    'default_price_amount' => $product->default_price->unit_amount,
                    'default_price_data' => $product->default_price->toArray(),
                ]);
            });

        Notification::make()
            ->title('Productos sincronizados')
            ->body('Los productos de Stripe se han sincronizado correctamente.')
            ->send();
    }
}
