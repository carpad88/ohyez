<?php

namespace App\Models;

use App\Traits\CrudBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use CrudBy, SoftDeletes;

    protected function casts(): array
    {
        return [
            'default_price_data' => 'array',
            'metadata' => 'array',
        ];
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
