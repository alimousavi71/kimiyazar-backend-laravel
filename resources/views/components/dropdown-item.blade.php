@props(['href' => null, 'icon' => null, 'variant' => 'default'])

@php
    $variants = [
        'default' => 'text-gray-700 hover:bg-gray-50',
        'danger' => 'text-red-600 hover:bg-red-50',
        'primary' => 'text-green-600 hover:bg-green-50',
    ];
@endphp

@if($href)
    <a href="{{ $href }}"
        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 cursor-pointer {{ $variants[$variant] }}"
        role="menuitem">
        @if($icon)
            <x-icon name="{{ $icon }}" size="sm" class="flex-shrink-0" />
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button type="button"
        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 w-full text-start cursor-pointer {{ $variants[$variant] }}"
        role="menuitem" {{ $attributes }}>
        @if($icon)
            <x-icon name="{{ $icon }}" size="sm" class="flex-shrink-0" />
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif