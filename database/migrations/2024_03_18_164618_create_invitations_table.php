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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->uuid('code')->index();
            $table->string('password')->index();
            $table->enum('status', ['pending', 'confirmed', 'declined']);
            $table->timestamp('checkedIn')->nullable();
            $table->string('family');
            $table->string('phone');
            $table->integer('table')->nullable();
            $table->json('guests');
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
        Schema::dropIfExists('invitations');
    }
};
