<?php

namespace App\Traits;

/**
 * Trait for converting Persian and Arabic numbers to English numbers
 */
trait ConvertsPersianNumbers
{
    /**
     * Convert Persian and Arabic numbers to English numbers
     *
     * @param string $value
     * @return string
     */
    public function faToEnNumbers(string $value): string
    {
        return str_replace(
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'],
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $value
        );
    }
}
