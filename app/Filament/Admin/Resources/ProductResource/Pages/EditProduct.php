<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Cashier;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->formId('form'),
            $this->getCancelFormAction()
                ->formId('form'),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::FourExtraLarge;
    }

    protected function handleRecordUpdate(Product|Model $record, array $data): Model
    {
        Cashier::stripe()
            ->products
            ->update(
                $record->stripe_id,
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'metadata' => [...$data['metadata'], 'is_bundle' => $data['bundle']],
                    'active' => $data['active'],
                ]
            );

        return parent::handleRecordUpdate($record, $data);
    }
}
