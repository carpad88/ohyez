<?php

namespace App\Models;

use App\Traits\CrudBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Template extends Model
{
    use CrudBy, HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'sections' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::updating(function ($template) {
            if ($template->isDirty('cover') && ! empty($template->getOriginal('cover'))) {
                Storage::disk('templates')->delete($template->getOriginal('cover'));
            }
        });
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function coverUrl(): ?string
    {
        if (empty($this->cover)) {
            return null;
        }

        return Storage::disk('s3-templates')->url($this->cover);
    }
}
