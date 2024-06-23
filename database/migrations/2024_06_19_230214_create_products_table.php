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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->boolean('bundle')->default(true);
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->string('stripe_id');
            $table->string('default_price_id');
            $table->string('default_price_amount');
            $table->json('default_price_data');
            $table->string('description')->nullable();
            $table->json('metadata')->nullable();
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
        Schema::dropIfExists('products');
    }
};
