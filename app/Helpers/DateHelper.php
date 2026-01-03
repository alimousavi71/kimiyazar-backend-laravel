<?php

namespace App\Helpers;

use App\Services\DateService;

/**
 * Helper functions for date formatting
 */

if (!function_exists('format_date')) {
    /**
     * Format date based on current locale
     *
     * @param \Carbon\Carbon|string|null $date
     * @param string|null $format
     * @param string|null $locale
     * @return string
     */
    function format_date($date, ?string $format = null, ?string $locale = null): string
    {
        return DateService::format($date, $format, $locale);
    }
}

if (!function_exists('format_date_time')) {
    /**
     * Format date with time based on current locale
     *
     * @param \Carbon\Carbon|string|null $date
     * @param string|null $locale
     * @return string
     */
    function format_date_time($date, ?string $locale = null): string
    {
        return DateService::formatDateTime($date, $locale);
    }
}

if (!function_exists('format_date_only')) {
    /**
     * Format date only (without time) based on current locale
     *
     * @param \Carbon\Carbon|string|null $date
     * @param string|null $locale
     * @return string
     */
    function format_date_only($date, ?string $locale = null): string
    {
        return DateService::formatDate($date, $locale);
    }
}

if (!function_exists('format_date_time_full')) {
    /**
     * Format date with full time (including seconds) based on current locale
     *
     * @param \Carbon\Carbon|string|null $date
     * @param string|null $locale
     * @return string
     */
    function format_date_time_full($date, ?string $locale = null): string
    {
        return DateService::formatDateTimeFull($date, $locale);
    }
}

if (!function_exists('date_diff_for_humans')) {
    /**
     * Format date difference in human-readable format
     *
     * @param \Carbon\Carbon|string|null $date
     * @param string|null $locale
     * @return string
     */
    function date_diff_for_humans($date, ?string $locale = null): string
    {
        return DateService::diffForHumans($date, $locale);
    }
}
