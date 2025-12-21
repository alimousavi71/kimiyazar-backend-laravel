<x-layouts.admin :title="__('admin/product-prices.title')" :header-title="__('admin/product-prices.title')"
    :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/product-prices.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/product-prices.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/product-prices.description') }}</p>
            </div>
            <div class="flex gap-2">
                <button type="button" id="sync-today-btn"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                    {{ __('admin/product-prices.buttons.sync_today') }}
                </button>
                <button type="button" id="bulk-save-btn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ __('admin/product-prices.buttons.save_all') }}
                </button>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <x-session-messages />

        <!-- Search and Actions -->
        <x-card class="mb-6">
            <div class="flex flex-col sm:flex-row gap-4 items-center">
                <div class="flex-1 w-full">
                    <form method="GET" action="{{ route('admin.product-prices.index') }}" class="flex gap-2">
                        @if($perPage)
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                        @endif
                        <input type="text" name="search" id="search-input"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('admin/product-prices.placeholders.search') }}"
                            class="flex-1 px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 bg-white shadow-sm hover:shadow-md focus:shadow-md">
                        <button type="submit"
                            class="px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium">
                            {{ __('admin/components.buttons.search') }}
                        </button>
                        @if($search)
                            <a href="{{ route('admin.product-prices.index', ['per_page' => $perPage]) }}"
                                class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors text-sm font-medium">
                                {{ __('admin/components.buttons.reset') }}
                            </a>
                        @endif
                    </form>
                </div>
                <div class="flex items-center gap-2">
                    <label for="per-page-select" class="text-sm text-gray-700 whitespace-nowrap">
                        {{ __('admin/components.pagination.per_page') }}:
                    </label>
                    <select name="per_page" id="per-page-select"
                        onchange="window.location.href = '{{ route('admin.product-prices.index', ['search' => $search]) }}&per_page=' + this.value"
                        class="px-3 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 bg-white shadow-sm hover:shadow-md focus:shadow-md">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
        </x-card>

        <!-- Products Price Table -->
        <x-card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('admin/products.fields.name') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('admin/product-prices.fields.current_price') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('admin/product-prices.fields.new_price') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('admin/products.fields.currency_code') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('admin/components.table.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="products-table-body">
                        @forelse($products as $product)
                            <tr data-product-id="{{ $product->id }}" class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    @if($product->category)
                                        <div class="text-xs text-gray-500">{{ $product->category->name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->latest_price)
                                        <div class="text-sm text-gray-900">
                                            {{ number_format($product->latest_price->price) }}
                                            {{ $product->latest_price->currency_code->label() }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $product->latest_price->created_at->format('Y-m-d') }}
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">{{ __('admin/product-prices.messages.no_price') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" step="0.01" min="0"
                                        data-product-id="{{ $product->id }}"
                                        data-field="price"
                                        value="{{ $product->latest_price?->price ?? '' }}"
                                        placeholder="{{ __('admin/product-prices.placeholders.price') }}"
                                        class="price-input w-32 px-3 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 bg-white shadow-sm hover:shadow-md focus:shadow-md">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select data-product-id="{{ $product->id }}"
                                        data-field="currency_code"
                                        class="currency-select w-40 px-3 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 bg-white shadow-sm hover:shadow-md focus:shadow-md">
                                        <option value="">{{ __('admin/components.status.select') }}</option>
                                        @foreach(\App\Enums\Database\CurrencyCode::cases() as $currency)
                                            <option value="{{ $currency->value }}"
                                                {{ $product->latest_price?->currency_code?->value === $currency->value ? 'selected' : '' }}>
                                                {{ $currency->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button type="button"
                                        data-product-id="{{ $product->id }}"
                                        class="save-price-btn px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                                        {{ __('admin/product-prices.buttons.save') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages() || $products->total() > 0)
                <x-pagination :paginator="$products" />
            @endif
        </x-card>
    </div>

    @push('scripts')
        <script>
            // Pass routes to JavaScript
            window.productPriceRoutes = {
                updateTemplate: '{{ route('admin.product-prices.update', ['productId' => '__PRODUCT_ID__']) }}',
                bulkUpdate: '{{ route('admin.product-prices.bulk-update') }}',
                syncToday: '{{ route('admin.product-prices.sync-today') }}'
            };
        </script>
        @vite('resources/js/product-price-management.js')
    @endpush
</x-layouts.admin>
