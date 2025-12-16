<?php

namespace App\Enums\Database;

enum ContentType: string
{
    case NEWS = 'news';
    case ARTICLE = 'article';
    case PAGE = 'page';

    /**
     * Get all type values as array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable label for the type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::NEWS => __('admin/contents.types.news'),
            self::ARTICLE => __('admin/contents.types.article'),
            self::PAGE => __('admin/contents.types.page'),
        };
    }
}

