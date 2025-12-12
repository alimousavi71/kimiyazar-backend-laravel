<?php

namespace App\Helpers;

class DirectionHelper
{
    /**
     * Get the current direction (rtl or ltr)
     */
    public static function getDirection(): string
    {
        $config = config('direction');

        if ($config['auto_detect'] && in_array(app()->getLocale(), $config['rtl_locales'])) {
            return 'rtl';
        }

        return $config['direction'] ?? 'ltr';
    }

    /**
     * Check if current direction is RTL
     */
    public static function isRtl(): bool
    {
        return self::getDirection() === 'rtl';
    }

    /**
     * Check if current direction is LTR
     */
    public static function isLtr(): bool
    {
        return self::getDirection() === 'ltr';
    }
}
