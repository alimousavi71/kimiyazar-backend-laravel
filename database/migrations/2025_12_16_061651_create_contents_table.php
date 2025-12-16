<?php

use App\Enums\Database\ContentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', array_column(ContentType::cases(), 'value'));
            $table->string('title', 512);
            $table->string('slug', 512);
            $table->text('body')->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('visit_count')->default(0);
            $table->boolean('is_undeletable')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Unique constraint: slug must be unique per type
            $table->unique(['type', 'slug']);
            $table->index('type');
            $table->index('is_active');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
