<?php

namespace App\Enums\Database;

enum ProductUnit: string
{
    case PIECE = 'piece';
    case KILOGRAM = 'kilogram';
    case GRAM = 'gram';
    case LITER = 'liter';
    case MILLILITER = 'milliliter';
    case METER = 'meter';
    case CENTIMETER = 'centimeter';
    case BOX = 'box';
    case PACK = 'pack';

    /**
     * Get all unit values as array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable label for the unit.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PIECE => __('admin/products.units.piece'),
            self::KILOGRAM => __('admin/products.units.kilogram'),
            self::GRAM => __('admin/products.units.gram'),
            self::LITER => __('admin/products.units.liter'),
            self::MILLILITER => __('admin/products.units.milliliter'),
            self::METER => __('admin/products.units.meter'),
            self::CENTIMETER => __('admin/products.units.centimeter'),
            self::BOX => __('admin/products.units.box'),
            self::PACK => __('admin/products.units.pack'),
        };
    }
}
