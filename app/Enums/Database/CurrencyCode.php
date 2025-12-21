<?php

namespace App\Enums\Database;

enum CurrencyCode: string
{
    case IRR = 'IRR';
    case USD = 'USD';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case AED = 'AED';
    case TRY = 'TRY';

    /**
     * Get all currency code values as array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable label for the currency code.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::IRR => __('admin/products.currencies.irr'),
            self::USD => __('admin/products.currencies.usd'),
            self::EUR => __('admin/products.currencies.eur'),
            self::GBP => __('admin/products.currencies.gbp'),
            self::AED => __('admin/products.currencies.aed'),
            self::TRY => __('admin/products.currencies.try'),
        };
    }
}
