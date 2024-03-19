<?php

namespace App\Models;

use App\Traits\CrudBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use CrudBy, HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [];
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }
}
