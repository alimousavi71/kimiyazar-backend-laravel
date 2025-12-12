@props([
    'title' => '',
    'description' => '',
    'time' => '',
    'icon' => 'bell',
    'iconColor' => 'blue',
    'href' => '#',
    'unread' => false
])
@php
    $iconColors = [
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'yellow' => 'bg-yellow-100 text-yellow-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'red' => 'bg-red-100 text-red-600',
        'indigo' => 'bg-indigo-100 text-indigo-600',
        'pink' => 'bg-pink-100 text-pink-600',
    ];

    $iconColorClass = $iconColors[$iconColor] ?? $iconColors['blue'];
@endphp

<a 
    href="{{ $href }}" 
    class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 {{ $unread ? 'bg-blue-50/50' : '' }}"
>
    <div class="shrink-0 mt-0.5">
    <div class="w-8 h-8 rounded-lg {{ $iconColorClass }} flex items-center justify-center">
            <x-icon name="{{ $icon }}" size="sm" />
        </div>
    </div>
<div class="flex-1 min-w-0">
        <div class="flex items-start justify-between gap-2">
            <p class="text-sm font-medium text-gray-900 {{ $unread ? 'font-semibold' : '' }}">{{ $title }}</p>
        @if($unread)
            <span class="shrink-0 w-2 h-2 rounded-full bg-blue-600 mt-1.5"></span>
        @endif
        </div>
        @if($description)
            <p class="text-xs text-gray-500 mt-0.5">{{ $description }}</p>
        @endif
        @if($time)
            <p class="text-xs text-gray-400 mt-1">{{ $time }}</p>
        @endif
    </div>
</a>

