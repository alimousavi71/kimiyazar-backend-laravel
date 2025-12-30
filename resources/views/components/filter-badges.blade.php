@props(['filters' => []])

@php
    // Get active filters from request
    $activeFilters = [];
    foreach ($filters as $key => $label) {
        // Get filter value from request (handles both filter[key] and filter.key formats)
        $filterData = request()->input('filter', []);
        $value = $filterData[$key] ?? null;

        // Also check query string directly for nested array format
        if ($value === null) {
            $query = request()->query();
            $value = $query['filter'][$key] ?? null;
        }

        // Show badge if value is not null and not empty string (allow '0' as valid value)
        if ($value !== null && $value !== '') {
            // Format the value for display
            $displayValue = $value;
            if ($value === '1' && ($key === 'verified' || $key === 'email_verified' || $key === 'is_active')) {
                $displayValue = __('admin/components.filter_badges.yes');
            } elseif ($value === '0' && ($key === 'is_active' || $key === 'is_block')) {
                $displayValue = __('admin/components.filter_badges.no');
            } elseif ($key === 'is_root') {
                // Special handling for is_root filter
                if ($value === '1' || $value === 1) {
                    $displayValue = __('admin/categories.status.root');
                } elseif ($value === '0' || $value === 0) {
                    $displayValue = __('admin/categories.status.has_parent');
                }
            } elseif ($value === 'null' && $key === 'parent_id') {
                $displayValue = __('admin/categories.status.root');
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
            @php
                // Build query parameters without the current filter
                $queryParams = request()->query();

                // Handle different parameter types
                if ($key === 'sort') {
                    // Sort is at root level, not under filter
                    unset($queryParams[$key]);
                } else {
                    // Regular filter parameters are under filter array
                    unset($queryParams["filter"][$key]);
                    // Remove empty filter array
                    if (isset($queryParams["filter"]) && empty($queryParams["filter"])) {
                        unset($queryParams["filter"]);
                    }
                }

                $removeUrl = request()->url() . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '');
            @endphp
            <a href="{{ $removeUrl }}"
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