@props(['id', 'title' => null, 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
    ];
@endphp

<div x-data="{ open: false }" x-show="open" x-cloak @keydown.escape.window="open = false"
    @open-modal.window="if ($event.detail === '{{ $id }}') open = true"
    @close-modal.window="if ($event.detail === '{{ $id }}') open = false" id="{{ $id }}"
    class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
    <!-- Backdrop -->
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" aria-hidden="true"></div>

    <!-- Modal -->
    <div x-show="open" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative bg-white rounded-2xl shadow-2xl w-full {{ $sizes[$size] }} max-h-[90vh] overflow-hidden flex flex-col border border-gray-100 z-50"
        role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title" @click.stop>
        @if($title)
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 id="{{ $id }}-title" class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                <button @click="open = false"
                    class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-xl hover:bg-gray-100"
                    aria-label="Close modal">
                    <x-icon name="x" size="xl" />
                </button>
            </div>
        @else
            <button @click="open = false"
                class="absolute top-4 end-4 text-gray-400 hover:text-gray-600 transition-colors z-10 p-2 rounded-xl hover:bg-gray-100"
                aria-label="Close modal">
                <x-icon name="x" size="xl" />
            </button>
        @endif

        <div class="px-6 py-4 overflow-y-auto flex-1">
            {{ $slot }}
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>