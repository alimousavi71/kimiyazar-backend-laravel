@props(['id', 'title' => 'Filters', 'action' => '', 'method' => 'GET'])

<div x-data="{ open: false }" x-show="open" x-cloak
    @open-filter-sidebar.window="if ($event.detail === '{{ $id }}') { open = true; }"
    @close-filter-sidebar.window="if ($event.detail === '{{ $id }}') { open = false; }"
    @keydown.escape.window="open = false" id="{{ $id }}" class="fixed inset-0 z-50 overflow-hidden">
    <!-- Backdrop -->
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-black/50 bg-opacity-10 transition-opacity" aria-hidden="true"></div>

    <!-- Sidebar -->
    <div x-show="open" x-data="{ isRtl: document.documentElement.dir === 'rtl' }"
        x-transition:enter="ease-out duration-300"
        x-bind:x-transition:enter-start="isRtl ? '-translate-x-full' : 'translate-x-full'"
        x-transition:enter-end="translate-x-0" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-bind:x-transition:leave-end="isRtl ? '-translate-x-full' : 'translate-x-full'"
        class="fixed end-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col z-50"
        @click.away="open = false">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
            <button type="button" @click="open = false"
                class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-xl hover:bg-gray-100"
                aria-label="Close filters">
                <x-icon name="x" size="xl" />
            </button>
        </div>

        <!-- Filter Content -->
        <form method="{{ $method }}" action="{{ $action ?: request()->url() }}"
            class="flex-1 flex flex-col overflow-hidden">
            <!-- Preserve search and other query parameters -->
            @if(request()->query('search'))
                <input type="hidden" name="search" value="{{ request()->query('search') }}">
            @endif

            <div class="flex-1 overflow-y-auto px-6 py-4">
                {{ $slot }}
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-end gap-3">
                <x-button variant="secondary" size="md" type="button" @click="open = false">
                    Cancel
                </x-button>
                <x-button variant="primary" size="md" type="submit">
                    Apply Filters
                </x-button>
            </div>
        </form>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>