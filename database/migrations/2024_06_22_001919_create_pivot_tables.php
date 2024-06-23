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
        Schema::create('feature_product', function (Blueprint $table) {
            $table->foreignId('feature_id');
            $table->foreignId('product_id');

            $table->unique(['feature_id', 'product_id']);
        });

        Schema::create('event_feature', function (Blueprint $table) {
            $table->foreignId('event_id');
            $table->foreignId('feature_id');

            $table->unique(['event_id', 'feature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_feature');
        Schema::dropIfExists('feature_product');
    }
};
