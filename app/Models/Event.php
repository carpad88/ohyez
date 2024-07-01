<?php

namespace App\Models;

use App\Enums\EventType;
use App\Traits\CrudBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use CrudBy, HasFactory, SoftDeletes;

    protected $appends = [
        'receptionLocation',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'content' => 'array',
            'event_type' => EventType::class,
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
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
        return $this->hasMany(\App\Models\Invitation::class, 'event_id');
    }

    public function guests(): HasManyThrough
    {
        return $this->hasManyThrough(Guest::class, Invitation::class);
    }

    public function plan()
    {
        return $this->payments
            ->filter(fn (Payment $payment) => $payment->product->bundle)
            ->first()
            ->product;
    }

    public function hasFeaturesWithCode(array|string $codes): bool
    {
        $featuresToCheck = is_array($codes) ? $codes : [$codes];

        return $this->features()->get()->contains(fn ($feature) => in_array($feature->code, $featuresToCheck));
    }

    public function invitationsCount($status = null): int
    {
        if ($status) {
            return $this->invitations
                ->filter(fn (Invitation $invitation) => $invitation->status === $status)
                ->count();
        }

        return $this->invitations->count();
    }

    public function guestsConfirmed(): int
    {
        return $this->guests->where('confirmed', true)->count();
    }

    public function getReceptionLocationAttribute(): array
    {
        return [
            'lat' => (float) $this->content['locations']['receptionLocation']['lat'],
            'lng' => (float) $this->content['locations']['receptionLocation']['lng'],
        ];
    }

    public static function getComputedLocation(): string
    {
        return 'receptionLocation';
    }
}
