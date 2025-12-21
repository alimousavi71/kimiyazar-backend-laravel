<?php

namespace App\Enums\Database;

enum ProductStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ARCHIVED = 'archived';

    /**
     * Get all status values as array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable label for the status.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::DRAFT => __('admin/products.statuses.draft'),
            self::ACTIVE => __('admin/products.statuses.active'),
            self::INACTIVE => __('admin/products.statuses.inactive'),
            self::ARCHIVED => __('admin/products.statuses.archived'),
        };
    }
}
