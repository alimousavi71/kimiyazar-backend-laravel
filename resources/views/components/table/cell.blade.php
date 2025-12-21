@props(['header' => false, 'sortable' => false, 'sortField' => null, 'sortDirection' => null])

@php
    $baseClass = $header
        ? 'px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50'
        : 'px-4 py-3 whitespace-nowrap text-sm text-gray-900';

    $sortableClass = $sortable ? 'cursor-pointer hover:bg-gray-100 transition-colors group' : '';

    // Get current sort from query string
    $currentSort = request()->query('sort', '');
    $currentField = null;
    $currentDirection = null;

    if ($currentSort) {
        if (str_starts_with($currentSort, '-')) {
            $currentField = substr($currentSort, 1);
            $currentDirection = 'desc';
        } elseif (str_starts_with($currentSort, '+')) {
            $currentField = substr($currentSort, 1);
            $currentDirection = 'asc';
        } else {
            $currentField = $currentSort;
            $currentDirection = 'asc';
        }
    }

    // Determine sort direction for this column
    $isActive = $sortable && $sortField && $currentField === $sortField;
    $displayDirection = $isActive ? $currentDirection : null;

    // Build sort URL
    $sortUrl = null;
    if ($sortable && $sortField) {
        $queryParams = request()->except(['sort', 'page']);

        if ($isActive && $currentDirection === 'asc') {
            // Toggle to descending
            $queryParams['sort'] = '-' . $sortField;
        } elseif ($isActive && $currentDirection === 'desc') {
            // Remove sort (or toggle to ascending)
            $queryParams['sort'] = $sortField; // No prefix for ascending (Spatie Query Builder format)
        } else {
            // Set to ascending
            $queryParams['sort'] = $sortField; // No prefix for ascending (Spatie Query Builder format)
        }

        $sortUrl = request()->url() . '?' . http_build_query($queryParams);
    }
@endphp

@if($header)
    @if($sortable && $sortField && $sortUrl)
        <th {{ $attributes->except('sortField')->merge(['class' => "$baseClass $sortableClass"]) }}>
            <a href="{{ $sortUrl }}" class="flex items-center gap-1.5 w-full">
                <span>{{ $slot }}</span>
                <span class="inline-flex items-center">
                    @if($displayDirection === 'asc')
                        <x-icon name="chevron-up" size="xs" class="text-green-600" />
                    @elseif($displayDirection === 'desc')
                        <x-icon name="chevron-down" size="xs" class="text-green-600" />
                    @else
                        <x-icon name="sort" size="xs" class="text-gray-400 group-hover:text-gray-600 transition-colors" />
                    @endif
                </span>
            </a>
        </th>
    @else
        <th {{ $attributes->except('sortField')->merge(['class' => "$baseClass $sortableClass"]) }}>
            <div class="flex items-center gap-1.5">
                <span>{{ $slot }}</span>
                @if($sortable)
                    <span class="inline-flex items-center">
                        @if($sortDirection === 'asc')
                            <x-icon name="chevron-up" size="xs" class="text-green-600" />
                        @elseif($sortDirection === 'desc')
                            <x-icon name="chevron-down" size="xs" class="text-green-600" />
                        @else
                            <x-icon name="sort" size="xs" class="text-gray-400" />
                        @endif
                    </span>
                @endif
            </div>
        </th>
    @endif
@else
    <td {{ $attributes->merge(['class' => $baseClass]) }}>
        {{ $slot }}
    </td>
@endif