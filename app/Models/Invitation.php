<?php

namespace App\Models;

use App\Enums\InvitationStatus;
use App\Traits\CrudBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use CrudBy, HasFactory, SoftDeletes;

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'status' => InvitationStatus::class,
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function allConfirmedGuestsHaveTableAssigned(): bool
    {
        $confirmedGuests = $this->guests()->where('confirmed', true);

        return $confirmedGuests->count() === $confirmedGuests->where('table', '>', 0)->count();
    }
}
