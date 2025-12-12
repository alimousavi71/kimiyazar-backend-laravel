@props(['name', 'type' => 'regular', 'size' => 'md'])

@php
    $sizes = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
        '3xl' => 'text-3xl',
    ];

    $types = [
        'regular' => 'bx',
        'solid' => 'bxs',
        'logo' => 'bxl',
    ];
@endphp

<i
    class="{{ $types[$type] ?? 'bx' }} bx-{{ $name }} {{ $sizes[$size] ?? 'text-base' }} {{ $attributes->get('class') }}"></i>