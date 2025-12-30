<?php

use App\Enums\Database\ProductUnit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Customer type and reference
            $table->enum('customer_type', ['real', 'legal']);
            $table->unsignedBigInteger('member_id')->nullable();

            // Individual (real person) information
            $table->string('full_name', 255)->nullable();
            $table->string('national_code', 255)->nullable();
            $table->string('national_card_photo', 255)->default('not_set')->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('mobile', 255)->nullable();
            $table->tinyInteger('is_photo_sent')->default(0);

            // Legal entity (company) information
            $table->string('company_name', 255)->nullable();
            $table->string('economic_code', 255)->nullable();
            $table->integer('registration_number')->nullable();
            $table->string('official_gazette_photo', 255)->default('not_set')->nullable();

            // Location information
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('city', 255)->nullable();
            $table->string('postal_code', 255)->nullable();

            // Receiver details
            $table->string('receiver_full_name', 255)->nullable();
            $table->string('delivery_method', 255)->nullable();
            $table->longText('address')->nullable();

            // Single product details
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->enum('unit', array_column(ProductUnit::cases(), 'value'))->default(ProductUnit::PIECE->value);
            $table->decimal('unit_price', 15, 0)->nullable();
            $table->string('product_description', 255)->nullable();

            // Payment information
            $table->unsignedBigInteger('payment_bank_id')->nullable();
            $table->enum('payment_type', ['online_gateway', 'bank_deposit', 'wallet', 'pos', 'cash_on_delivery'])->default('online_gateway');
            $table->string('total_payment_amount', 255)->default('');
            $table->string('payment_date', 255)->nullable();
            $table->string('payment_time', 255)->nullable();

            // Administration & status
            $table->longText('admin_note')->nullable();
            $table->enum('status', [
                'pending_payment',
                'paid',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'returned'
            ])->default('pending_payment');
            $table->tinyInteger('is_registered_service')->default(0);
            $table->tinyInteger('is_viewed')->default(0);

            // System fields
            $table->unsignedInteger('created_at')->nullable();

            // Indexes
            $table->index('customer_type');
            $table->index('member_id');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('product_id');
            $table->index('payment_bank_id');
            $table->index('status');
            $table->index('is_viewed');
            $table->index('created_at');

            // Foreign keys
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');

            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('set null');

            $table->foreign('payment_bank_id')
                ->references('id')
                ->on('banks')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
