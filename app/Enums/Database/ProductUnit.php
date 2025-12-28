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
    case TON = 'ton';
    case CAN = 'can';
    case PACKET = 'packet';
    case GALLON = 'gallon';
    case CAN_AND_PACKET = 'can_and_packet';

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
            self::TON => __('admin/products.units.ton'),
            self::CAN => __('admin/products.units.can'),
            self::PACKET => __('admin/products.units.packet'),
            self::GALLON => __('admin/products.units.gallon'),
            self::CAN_AND_PACKET => __('admin/products.units.can_and_packet'),
        };
    }
}
