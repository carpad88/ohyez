<?php

namespace App\Models;

use App\Enums\EventType;
use App\Traits\CrudBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use CrudBy, HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'content' => 'array',
            'event_type' => EventType::class,
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(\App\Models\Invitations::class);
    }
}