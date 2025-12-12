@props(['trigger', 'align' => 'end'])

@php
    $alignments = [
        'start' => 'start-0',
        'end' => 'end-0',
    ];
@endphp

<div x-data="{ open: false }" class="relative">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-show="open" @click.away="open = false" @keydown.escape.window="open = false"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
        x-cloak
        class="absolute {{ $alignments[$align] }} mt-2 w-56 rounded-lg shadow-lg bg-white border border-gray-200 py-1 z-50"
        style="display: none;" role="menu">
        {{ $slot }}
    </div>
</div>