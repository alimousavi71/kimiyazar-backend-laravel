@props(['type' => 'info', 'dismissible' => false])

@php
    $colors = [
        'success' => 'bg-green-50 text-green-800 border-green-200',
        'danger' => 'bg-red-50 text-red-800 border-red-200',
        'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'info' => 'bg-blue-50 text-blue-800 border-blue-200',
    ];

    $iconNames = [
        'success' => 'check-circle',
        'danger' => 'x-circle',
        'warning' => 'error-circle',
        'info' => 'info-circle',
    ];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition
    class="p-4 rounded-2xl border {{ $colors[$type] }} flex items-start gap-3 shadow-sm">
    <x-icon name="{{ $iconNames[$type] }}" size="xl" class="flex-shrink-0 mt-0.5" />
    <div class="flex-1">
        {{ $slot }}
    </div>
    @if($dismissible)
        <button @click="show = false"
            class="text-current opacity-70 hover:opacity-100 transition-opacity p-1 rounded-lg hover:bg-black/5 flex-shrink-0">
            <span class="sr-only">{{ __('admin/components.buttons.close') }}</span>
            <x-icon name="x" size="md" />
        </button>
    @endif
</div>