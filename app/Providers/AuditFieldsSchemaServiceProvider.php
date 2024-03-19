<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AuditFieldsSchemaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blueprint::macro('auditFields', function () {
            $this->foreignId('created_by')->constrained('users');
            $this->foreignId('updated_by')->constrained('users');
            $this->foreignId('deleted_by')->nullable()->constrained('users');
        });
    }
}
