<?php

namespace App\Enums\Database;

enum SettingKey: string
{
    case TEL = 'tel';
    case MOBILE = 'mobile';
    case ADDRESS = 'address';
    case TELEGRAM = 'telegram';
    case INSTAGRAM = 'instagram';
    case EMAIL = 'email';
    case TITLE = 'title';
    case DESCRIPTION = 'description';
    case KEYWORDS = 'keywords';

    /**
     * Get all key values as array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable label for the key.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::TEL => __('admin/settings.keys.tel'),
            self::MOBILE => __('admin/settings.keys.mobile'),
            self::ADDRESS => __('admin/settings.keys.address'),
            self::TELEGRAM => __('admin/settings.keys.telegram'),
            self::INSTAGRAM => __('admin/settings.keys.instagram'),
            self::EMAIL => __('admin/settings.keys.email'),
            self::TITLE => __('admin/settings.keys.title'),
            self::DESCRIPTION => __('admin/settings.keys.description'),
            self::KEYWORDS => __('admin/settings.keys.keywords'),
        };
    }
}
