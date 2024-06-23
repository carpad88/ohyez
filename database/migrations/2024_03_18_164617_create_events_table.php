<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->string('code')->unique()->index();
            $table->string('title');
            $table->uuid();
            $table->string('password');

            $table->foreignIdFor(\App\Models\Template::class)->nullable();
            $table->string('event_type')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('logo')->nullable();
            $table->string('music')->nullable();
            $table->boolean('counter')->default(true);
            $table->json('content')->nullable();
            $table->auditFields();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
