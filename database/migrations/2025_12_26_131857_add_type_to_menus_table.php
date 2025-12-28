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
        Schema::table('menus', function (Blueprint $table) {
            // Check if column exists, if so drop it first (for SQLite compatibility)
            if (Schema::hasColumn('menus', 'type')) {
                $table->dropIndex(['type']);
                $table->dropColumn('type');
            }

            $table->enum('type', ['quick_access', 'services', 'useful_links', 'custom'])->default('custom')->after('name');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropColumn('type');
        });
    }
};
