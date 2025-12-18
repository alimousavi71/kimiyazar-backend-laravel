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

    /**
     * Get the field type for this setting.
     * 
     * @return string 'text'|'email'|'url'|'tel'|'textarea'
     */
    public function fieldType(): string
    {
        return match ($this) {
            self::EMAIL => 'email',
            self::TELEGRAM, self::INSTAGRAM => 'url',
            self::TEL, self::MOBILE => 'tel',
            self::ADDRESS, self::DESCRIPTION => 'textarea',
            default => 'text',
        };
    }

    /**
     * Get validation rules for this setting.
     *
     * @return array<string, string|array>
     */
    public function validationRules(): array
    {
        return match ($this) {
            self::EMAIL => ['nullable', 'string', 'max:255', 'email'],
            self::TELEGRAM, self::INSTAGRAM => ['nullable', 'string', 'max:255', 'url'],
            self::TEL, self::MOBILE => ['nullable', 'string', 'max:50'],
            self::TITLE => ['nullable', 'string', 'max:255'],
            self::KEYWORDS => ['nullable', 'string', 'max:500'],
            self::ADDRESS, self::DESCRIPTION => ['nullable', 'string', 'max:1000'],
        };
    }

    /**
     * Get the number of rows for textarea fields.
     *
     * @return int
     */
    public function textareaRows(): int
    {
        return match ($this) {
            self::ADDRESS => 3,
            self::DESCRIPTION => 5,
            default => 3,
        };
    }
}
