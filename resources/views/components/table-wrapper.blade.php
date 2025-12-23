@props([
    'searchPlaceholder' => null, 
    'searchValue' => '', 
    'filterSidebarId' => 'table-filters',
    'filterBadges' => [],
    'paginator' => null
])

@php
    $searchPlaceholder = $searchPlaceholder ?? __('admin/components.buttons.search');
@endphp

<div class="space-y-4">
    <!-- Main Form - Wraps Search, Filters, and Table -->
    <form method="GET" action="{{ request()->url() }}" class="space-y-3">
        <!-- Search and Filter Button -->
        <div class="flex items-center gap-3">
            <div class="flex-1 relative">
                <x-icon name="search" size="md" class="absolute start-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                <input 
                    type="text" 
                    name="filter[search]"
                    placeholder="{{ $searchPlaceholder }}" 
                    value="{{ $searchValue ?: request()->query('filter.search') }}"
                    class="w-full ps-10 pe-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 bg-white shadow-sm hover:shadow-md focus:shadow-md" 
                />
            </div>
            <x-button 
                variant="secondary" 
                size="md" 
                type="button"
                x-data
                @click="$dispatch('open-filter-sidebar', '{{ $filterSidebarId }}')"
                class="flex items-center gap-2"
            >
                <x-icon name="filter" size="md" />
                <span>{{ __('admin/components.buttons.filter') }}</span>
            </x-button>
        </div>

        <!-- Preserve all filter parameters as hidden inputs (including sort) -->
        @foreach(request()->except(['filter', 'page', '_token', '_method']) as $key => $value)
            @if(is_array($value))
                @foreach($value as $subValue)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $subValue }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        <!-- Filter Badges -->
        <x-filter-badges :filters="$filterBadges" />

        <!-- Table -->
        <div class="overflow-x-auto overflow-y-visible">
            {{ $slot }}
        </div>

        <!-- Pagination -->
        @if($paginator)
            <x-pagination :paginator="$paginator" />
        @endif
    </form>
</div>
