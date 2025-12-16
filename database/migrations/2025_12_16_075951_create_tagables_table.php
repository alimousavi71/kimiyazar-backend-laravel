<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
            $table->morphs('tagable'); // tagable_type, tagable_id
            $table->text('body')->nullable();
            $table->timestamps();

            // Prevent duplicate tag assignments
            // Note: morphs() already creates an index on tagable_type and tagable_id
            $table->unique(['tag_id', 'tagable_type', 'tagable_id'], 'tagable_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagables');
    }
};
