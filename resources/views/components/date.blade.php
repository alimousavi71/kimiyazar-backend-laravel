@props([
    'date' => null,
    'format' => null,
    'locale' => null,
    'type' => 'default' // 'default', 'date', 'datetime', 'datetime-full', 'diff'
])
@php
    if (!$date) {
        $formatted = '';
    } else {
        $locale = $locale ?? app()->getLocale();

        switch ($type) {
            case 'date':
                $formatted = \App\Services\DateService::formatDate($date, $locale);
                break;
            case 'datetime':
                $formatted = \App\Services\DateService::formatDateTime($date, $locale);
                break;
            case 'datetime-full':
                $formatted = \App\Services\DateService::formatDateTimeFull($date, $locale);
                break;
            case 'diff':
                $formatted = \App\Services\DateService::diffForHumans($date, $locale);
                break;
            default:
                $formatted = \App\Services\DateService::format($date, $format, $locale);
                break;
        }
    }
@endphp

<span {{ $attributes }}>{{ $formatted }}</span>
