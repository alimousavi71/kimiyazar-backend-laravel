<?php

namespace App\Services;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

class DateService
{
    /**
     * Format date based on current locale
     *
     * @param Carbon|string|null $date
     * @param string|null $format
     * @param string|null $locale
     * @return string
     */
    public static function format($date, ?string $format = null, ?string $locale = null): string
    {
        if (!$date) {
            return '';
        }

        // Convert to Carbon if string
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        // Get locale
        $locale = $locale ?? app()->getLocale();

        // Use Persian (Shamsi) for 'fa' locale, Gregorian for others
        if ($locale === 'fa') {
            return self::formatShamsi($date, $format);
        }

        return self::formatGregorian($date, $format);
    }

    /**
     * Format date in Shamsi (Persian) calendar
     *
     * @param Carbon $date
     * @param string|null $format
     * @return string
     */
    public static function formatShamsi(Carbon $date, ?string $format = null): string
    {
        // Default format for Persian dates
        $format = $format ?? 'Y/m/d H:i';

        try {
            // Check if Jalalian class exists (morilog/jalali package)
            if (!class_exists(Jalalian::class)) {
                // Fallback to Gregorian if package not installed
                return self::formatGregorian($date, $format);
            }

            // Convert to Jalali (Shamsi)
            $jalali = Jalalian::fromCarbon($date);

            // Format the date
            return $jalali->format($format);
        } catch (\Exception $e) {
            // Fallback to Gregorian if conversion fails
            return self::formatGregorian($date, $format);
        }
    }

    /**
     * Format date in Gregorian calendar
     *
     * @param Carbon $date
     * @param string|null $format
     * @return string
     */
    public static function formatGregorian(Carbon $date, ?string $format = null): string
    {
        // Default format for Gregorian dates
        $format = $format ?? 'Y-m-d H:i';

        return $date->format($format);
    }

    /**
     * Format date with time
     *
     * @param Carbon|string|null $date
     * @param string|null $locale
     * @return string
     */
    public static function formatDateTime($date, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'fa') {
            return self::format($date, 'Y/m/d H:i', $locale);
        }

        return self::format($date, 'Y-m-d H:i', $locale);
    }

    /**
     * Format date only (without time)
     *
     * @param Carbon|string|null $date
     * @param string|null $locale
     * @return string
     */
    public static function formatDate($date, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'fa') {
            return self::format($date, 'Y/m/d', $locale);
        }

        return self::format($date, 'Y-m-d', $locale);
    }

    /**
     * Format date with full time (including seconds)
     *
     * @param Carbon|string|null $date
     * @param string|null $locale
     * @return string
     */
    public static function formatDateTimeFull($date, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'fa') {
            return self::format($date, 'Y/m/d H:i:s', $locale);
        }

        return self::format($date, 'Y-m-d H:i:s', $locale);
    }

    /**
     * Format date in a human-readable way (e.g., "2 days ago")
     *
     * @param Carbon|string|null $date
     * @param string|null $locale
     * @return string
     */
    public static function diffForHumans($date, ?string $locale = null): string
    {
        if (!$date) {
            return '';
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        $locale = $locale ?? app()->getLocale();

        // For Persian locale, we'll use a custom implementation
        if ($locale === 'fa') {
            return self::diffForHumansPersian($date);
        }

        return $date->diffForHumans();
    }

    /**
     * Format date difference in Persian
     *
     * @param Carbon $date
     * @return string
     */
    protected static function diffForHumansPersian(Carbon $date): string
    {
        $now = Carbon::now();
        $diff = $date->diffInSeconds($now);

        if ($diff < 60) {
            return 'چند لحظه پیش';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return "{$minutes} دقیقه پیش";
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return "{$hours} ساعت پیش";
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return "{$days} روز پیش";
        } elseif ($diff < 2592000) {
            $weeks = floor($diff / 604800);
            return "{$weeks} هفته پیش";
        } elseif ($diff < 31536000) {
            $months = floor($diff / 2592000);
            return "{$months} ماه پیش";
        } else {
            $years = floor($diff / 31536000);
            return "{$years} سال پیش";
        }
    }

    /**
     * Get current date in the appropriate calendar
     *
     * @param string|null $locale
     * @return string
     */
    public static function now(?string $locale = null): string
    {
        return self::format(Carbon::now(), null, $locale);
    }
}
