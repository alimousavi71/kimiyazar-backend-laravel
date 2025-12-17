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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('code', 10)->index();
            $table->enum('type', ['sms', 'email', 'authenticator'])->default('sms');
            $table->integer('attempts')->default(0);
            $table->integer('max_attempts')->default(5);
            $table->timestamp('expired_at');
            $table->timestamp('used_at')->nullable();
            $table->boolean('is_used')->default(false)->index();
            $table->timestamps();

            // Composite index for user_id and is_used
            $table->index(['user_id', 'is_used']);
            // Composite index for code and is_used
            $table->index(['code', 'is_used']);
            // Index for expiration check
            $table->index('expired_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
