@props(['paginator'])

@if($paginator && ($paginator->hasPages() || $paginator->total() > 0))
    <div
        class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-3 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
        <!-- Status Information -->
        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-700">
            <span class="font-medium">{{ __('admin/components.pagination.total_records') }}:</span>
            <span class="text-gray-900 font-semibold">{{ number_format($paginator->total()) }}</span>
            @if($paginator->hasPages())
                <span class="text-gray-500">|</span>
                <span>{{ __('admin/components.pagination.showing') }}</span>
                <span class="font-medium text-gray-900">{{ number_format($paginator->firstItem()) }}</span>
                <span>{{ __('admin/components.pagination.to') }}</span>
                <span class="font-medium text-gray-900">{{ number_format($paginator->lastItem()) }}</span>
                <span>{{ __('admin/components.pagination.of') }}</span>
                <span class="font-medium text-gray-900">{{ number_format($paginator->total()) }}</span>
                <span class="text-gray-500">|</span>
                <span>{{ __('admin/components.pagination.page') }}</span>
                <span class="font-medium text-gray-900">{{ $paginator->currentPage() }}</span>
                <span>{{ __('admin/components.pagination.of') }}</span>
                <span class="font-medium text-gray-900">{{ $paginator->lastPage() }}</span>
            @endif
        </div>

        <!-- Pagination Controls -->
        @if($paginator->hasPages())
            <div class="flex items-center gap-2">
                <!-- Previous Button -->
                @if($paginator->onFirstPage())
                    <button type="button" disabled
                        class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-xl cursor-not-allowed shadow-sm">
                        <x-icon name="chevron-left" size="sm" />
                        <span class="ms-1">{{ __('admin/components.pagination.previous') }}</span>
                    </button>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 shadow-sm hover:shadow-md transition-all">
                        <x-icon name="chevron-left" size="sm" />
                        <span class="ms-1">{{ __('admin/components.pagination.previous') }}</span>
                    </a>
                @endif

                <!-- Page Numbers (Limited to 7 pages max for better UX) -->
                <div class="hidden sm:flex items-center gap-1">
                    @php
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();
                        $startPage = max(1, $currentPage - 3);
                        $endPage = min($lastPage, $currentPage + 3);

                        // Adjust if we're near the start or end
                        if ($endPage - $startPage < 6) {
                            if ($startPage == 1) {
                                $endPage = min($lastPage, $startPage + 6);
                            } else {
                                $startPage = max(1, $endPage - 6);
                            }
                        }
                    @endphp

                    @if($startPage > 1)
                        <a href="{{ $paginator->url(1) }}"
                            class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 shadow-sm hover:shadow-md transition-all">1</a>
                        @if($startPage > 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif

                    @for($page = $startPage; $page <= $endPage; $page++)
                        @if($page == $currentPage)
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-white bg-blue-600 rounded-xl shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $paginator->url($page) }}"
                                class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 shadow-sm hover:shadow-md transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    @if($endPage < $lastPage)
                        @if($endPage < $lastPage - 1)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ $paginator->url($lastPage) }}"
                            class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 shadow-sm hover:shadow-md transition-all">{{ $lastPage }}</a>
                    @endif
                </div>

                <!-- Next Button -->
                @if($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 shadow-sm hover:shadow-md transition-all">
                        <span class="me-1">{{ __('admin/components.pagination.next') }}</span>
                        <x-icon name="chevron-right" size="sm" />
                    </a>
                @else
                    <button type="button" disabled
                        class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-xl cursor-not-allowed shadow-sm">
                        <span class="me-1">{{ __('admin/components.pagination.next') }}</span>
                        <x-icon name="chevron-right" size="sm" />
                    </button>
                @endif
            </div>
        @endif
    </div>
@endif