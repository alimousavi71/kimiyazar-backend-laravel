@props(['filters' => []])

@php
    // Get active filters from request
    $activeFilters = [];
    foreach ($filters as $key => $label) {
        $value = request()->query($key);
        if ($value !== null && $value !== '' && $value !== '0') {
            // Format the value for display
            $displayValue = $value;
            if ($value === '1' && ($key === 'verified' || $key === 'email_verified')) {
                $displayValue = __('admin/components.filter_badges.yes');
            }

            $activeFilters[$key] = [
                'label' => $label,
                'value' => $displayValue,
            ];
        }
    }

    // Add sort to active filters if present
    $sort = request()->query('sort');
    if ($sort) {
        $sortField = str_replace(['+', '-'], '', $sort);
        $sortDirection = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $activeFilters['sort'] = [
            'label' => __('admin/components.filter_badges.sort'),
            'value' => ucfirst($sortField) . ' (' . $sortDirection . ')',
        ];
    }
@endphp

@if(count($activeFilters) > 0)
    <div class="flex flex-wrap items-center gap-2 mb-3">
        <span class="text-xs font-medium text-gray-600">{{ __('admin/components.filter_badges.active_filters') }}:</span>
        @foreach($activeFilters as $key => $filter)
            <a href="{{ request()->fullUrlWithQuery([$key => null]) }}"
                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 hover:bg-green-200 transition-colors">
                <span>{{ $filter['label'] }}: {{ $filter['value'] }}</span>
                <x-icon name="x" size="xs" class="cursor-pointer" />
            </a>
        @endforeach
        <a href="{{ request()->url() }}"
            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
            <span>{{ __('admin/components.filter_badges.clear_all') }}</span>
        </a>
    </div>
@endif