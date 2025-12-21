<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run triggers on MySQL/MariaDB
        $driver = DB::connection()->getDriverName();

        if (!in_array($driver, ['mysql', 'mariadb'])) {
            return;
        }

        // Create trigger for AFTER INSERT
        // Updates the product with the latest price information
        DB::unprepared('
            CREATE TRIGGER `product_price_after_insert`
            AFTER INSERT ON `product_prices`
            FOR EACH ROW
            BEGIN
                UPDATE `products` p
                INNER JOIN (
                    SELECT 
                        `product_id`,
                        `price`,
                        `currency_code`,
                        `created_at`
                    FROM `product_prices`
                    WHERE `product_id` = NEW.`product_id`
                    ORDER BY `created_at` DESC, `id` DESC
                    LIMIT 1
                ) AS latest_price ON p.`id` = latest_price.`product_id`
                SET 
                    p.`current_price` = latest_price.`price`,
                    p.`currency_code` = latest_price.`currency_code`,
                    p.`price_updated_at` = NOW(),
                    p.`price_effective_date` = DATE(latest_price.`created_at`)
                WHERE p.`id` = NEW.`product_id`;
            END
        ');

        // Create trigger for AFTER UPDATE
        // Updates the product with the latest price information
        DB::unprepared('
            CREATE TRIGGER `product_price_after_update`
            AFTER UPDATE ON `product_prices`
            FOR EACH ROW
            BEGIN
                UPDATE `products` p
                INNER JOIN (
                    SELECT 
                        `product_id`,
                        `price`,
                        `currency_code`,
                        `created_at`
                    FROM `product_prices`
                    WHERE `product_id` = NEW.`product_id`
                    ORDER BY `created_at` DESC, `id` DESC
                    LIMIT 1
                ) AS latest_price ON p.`id` = latest_price.`product_id`
                SET 
                    p.`current_price` = latest_price.`price`,
                    p.`currency_code` = latest_price.`currency_code`,
                    p.`price_updated_at` = NOW(),
                    p.`price_effective_date` = DATE(latest_price.`created_at`)
                WHERE p.`id` = NEW.`product_id`;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop triggers on MySQL/MariaDB
        $driver = DB::connection()->getDriverName();

        if (!in_array($driver, ['mysql', 'mariadb'])) {
            return;
        }

        DB::unprepared('DROP TRIGGER IF EXISTS `product_price_after_insert`');
        DB::unprepared('DROP TRIGGER IF EXISTS `product_price_after_update`');
    }
};
