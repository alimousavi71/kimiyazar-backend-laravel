<?php

use App\Enums\Database\ProductUnit;
use App\Enums\Database\ProductStatus;
use App\Enums\Database\CurrencyCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('slug')->unique()->index();
            $table->text('sale_description')->nullable();
            $table->enum('unit', array_column(ProductUnit::cases(), 'value'));
            $table->unsignedBigInteger('category_id')->nullable();
            $table->boolean('is_published')->default(false);
            $table->text('body')->nullable();
            $table->string('price_label')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->enum('status', array_column(ProductStatus::cases(), 'value'));
            $table->unsignedInteger('sort_order')->default(0);
            $table->decimal('current_price', 15, 0)->unsigned()->nullable();
            $table->enum('currency_code', array_column(CurrencyCode::cases(), 'value'))->nullable();
            $table->dateTime('price_updated_at')->nullable();
            $table->date('price_effective_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->index('category_id');
            $table->index('is_published');
            $table->index('status');
            $table->index('sort_order');
            $table->index('created_at');
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
