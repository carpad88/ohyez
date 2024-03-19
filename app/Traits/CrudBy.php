<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait CrudBy
{
    public static function bootCrudBy(): void
    {
        static::creating(function (Model $model) {
            if (! $model->isDirty('created_by')) {
                $model->created_by = auth()->user()->id ?? 1;
            }
            if (! $model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id ?? 1;
            }
        });

        static::updating(function ($model) {
            if (! $model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id ?? 1;
            }
        });

        static::restoring(function ($model) {
            $model->deleted_by = null;
        });

        static::deleting(function ($model) {
            if (! $model->isDirty('deleted_by')) {
                $deletedById = auth()->user()->id ?? 1;
                $model->withoutEvents(function () use ($model, $deletedById) {
                    $model->update(['deleted_by' => $deletedById]);
                });
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function destroyer()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
