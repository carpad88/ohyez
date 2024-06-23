<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;
use Laravel\Cashier\Cashier;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::FourExtraLarge;
    }

    protected function handleRecordCreation(array $data): Product
    {
        $stripeProduct = Cashier::stripe()->products->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'metadata' => [...$data['metadata'], 'is_bundle' => $data['bundle']],
            'default_price_data' => [
                'unit_amount' => $data['default_price_amount'] * 100,
                'currency' => 'mxn',
            ],
            'expand' => ['default_price'],
        ]);

        return static::getModel()::create([
            'name' => $stripeProduct->name,
            'description' => $stripeProduct->description,
            'metadata' => $stripeProduct->metadata->toArray(),
            'stripe_id' => $stripeProduct->id,
            'default_price_id' => $stripeProduct->default_price->id,
            'default_price_amount' => $stripeProduct->default_price->unit_amount,
            'default_price_data' => $stripeProduct->default_price->toArray(),
        ]);
    }
}
