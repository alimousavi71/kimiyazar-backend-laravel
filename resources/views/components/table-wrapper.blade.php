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
    
    <form method="GET" action="{{ request()->url() }}" class="space-y-3">
        
        @if($searchPlaceholder || !empty($filterBadges))
            <div class="flex items-center gap-3">
                @if($searchPlaceholder)
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
                @endif
                @if(!empty($filterBadges))
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
                @endif
            </div>
        @endif

        
        @foreach(request()->except(['filter', 'page', '_token', '_method']) as $key => $value)
            @if(is_array($value))
                @foreach($value as $subValue)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $subValue }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        
        <x-filter-badges :filters="$filterBadges" />

        
        <div class="overflow-x-auto overflow-y-visible">
            {{ $slot }}
        </div>

        
        @if($paginator)
            <x-pagination :paginator="$paginator" />
        @endif
    </form>
</div>
