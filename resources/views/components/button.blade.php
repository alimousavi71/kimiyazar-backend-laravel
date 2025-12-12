@props(['variant' => 'primary', 'size' => 'md'])

@php
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2',
        'secondary' => 'bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2',
        'outline' => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2',
    ];

    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-sm',
        'md' => 'px-3.5 py-2 text-base',
        'lg' => 'px-5 py-2.5 text-lg',
    ];

    $base = "inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md";

    // Get type from attributes, default to 'button'
    $type = $attributes->get('type', 'button');
@endphp

<button type="{{ $type }}" {{ $attributes->except('variant', 'size', 'type')->merge(['class' => "$base {$variants[$variant]} {$sizes[$size]}"]) }}>
    {{ $slot }}
</button>