@props(['align' => 'end', 'triggerClass' => ''])

@php
    $alignments = [
        'start' => 'start-0',
        'end' => 'end-0',
    ];
@endphp

<div x-data="{ open: false }" class="relative inline-block">
    <!-- Trigger Button -->
    <button type="button" @click="open = !open"
        class="inline-flex items-center cursor-pointer justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-all duration-200 {{ $triggerClass }}"
        aria-label="{{ __('admin/components.table.actions') }}">
        <x-icon name="dots-vertical-rounded" size="md" />
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" @click.away="open = false" @keydown.escape.window="open = false"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
        x-cloak
        class="absolute {{ $alignments[$align] }} mt-2 w-48 rounded-xl shadow-lg bg-white border border-gray-200 py-1 z-50"
        style="display: none;" role="menu" aria-orientation="vertical">
        {{ $slot }}
    </div>
</div>