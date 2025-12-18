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
        Schema::create('modals', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('content');
            $table->string('button_text', 100)->nullable();
            $table->string('button_url', 500)->nullable();
            $table->string('close_text', 100)->default('بستن');
            $table->boolean('is_rememberable')->default(true);
            $table->morphs('modalable');
            $table->boolean('is_published')->default(false);
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->unsignedInteger('priority')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('is_published');
            $table->index('priority');
            $table->index('start_at');
            $table->index('end_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modals');
    }
};
