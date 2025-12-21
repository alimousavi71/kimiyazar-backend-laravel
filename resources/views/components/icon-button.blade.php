@props([
    'icon' => 'menu',
    'size' => 'md',
    'variant' => 'default',
    'badge' => false,
    'badgeColor' => 'red'
])

@php
    $sizes = [
        'sm' => 'p-1.5',
        'md' => 'p-1.5',
        'lg' => 'p-2',
    ];

    $iconSizes = [
        'sm' => 'sm',
        'md' => 'md',
        'lg' => 'lg',
    ];

    $variants = [
        'default' => 'text-gray-600 hover:text-gray-900 hover:bg-gray-100',
        'primary' => 'text-green-600 hover:text-green-700 hover:bg-green-50',
        'secondary' => 'text-gray-500 hover:text-gray-700 hover:bg-gray-100',
    ];

    $badgeColors = [
        'red' => 'bg-red-500',
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'yellow' => 'bg-yellow-500',
    ];

    $base = "relative inline-flex items-center justify-center rounded-lg transition-all duration-200";
    $variantClass = $variants[$variant] ?? $variants['default'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $iconSize = $iconSizes[$size] ?? $iconSizes['md'];
    $badgeColorClass = $badgeColors[$badgeColor] ?? $badgeColors['red'];
@endphp

<button 
    type="button"
    {{ $attributes->merge(['class' => "$base $variantClass $sizeClass"]) }}
>
    <x-icon name="{{ $icon }}" size="{{ $iconSize }}" />
    @if($badge)
        <span class="absolute top-0.5 end-0.5 block h-2 w-2 rounded-full {{ $badgeColorClass }} ring-2 ring-white"></span>
    @endif
    {{ $slot }}
</button>

