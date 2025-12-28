<x-layouts.admin :title="__('admin/products.title')" :header-title="__('admin/products.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/products.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/products.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/products.description') }}</p>
            </div>
            <a href="{{ route('admin.products.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/products.add_new') }}
                </x-button>
            </a>
        </div>

        
        <x-session-messages />

        @php
            $categories = $categories ?? collect();
        @endphp

        
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="products-filters" :filter-badges="[
                'is_published' => __('admin/products.fields.is_published'),
                'status' => __('admin/products.fields.status'),
                'category_id' => __('admin/products.fields.category'),
            ]" :paginator="$products ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="name">{{ __('admin/products.fields.name') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="slug">{{ __('admin/products.fields.slug') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="category_id">{{ __('admin/products.fields.category') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="unit">{{ __('admin/products.fields.unit') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="status">{{ __('admin/products.fields.status') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_published">{{ __('admin/products.fields.is_published') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="current_price">{{ __('admin/products.fields.current_price') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="sort_order">{{ __('admin/products.fields.sort_order') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/products.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($products) && $products->count() > 0)
                            @foreach($products as $product)
                                <x-table.row data-product-id="{{ $product->id }}">
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $product->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ $product->name }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-700">{{ $product->slug }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($product->category)
                                            <span class="text-gray-700">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-gray-400">{{ __('admin/products.forms.placeholders.no_category') }}</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-700">{{ $product->unit->label() }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <x-badge variant="{{ $product->status->value === 'active' ? 'success' : ($product->status->value === 'draft' ? 'warning' : 'danger') }}" size="sm">
                                            {{ $product->status->label() }}
                                        </x-badge>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($product->is_published)
                                            <x-badge variant="success" size="sm">{{ __('admin/products.statuses.active') }}</x-badge>
                                        @else
                                            <x-badge variant="danger" size="sm">{{ __('admin/products.statuses.inactive') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($product->current_price)
                                            <span class="text-gray-700">{{ number_format($product->current_price) }} {{ $product->currency_code?->label() ?? '' }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $product->sort_order }}</span>
                                    </x-table.cell>
                                    <x-table.cell>{{ $product->created_at->format('Y-m-d') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.products.show', $product->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.products.edit', $product->id) }}"
                                                    icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $product->id }}, name: '{{ addslashes($product->name) }}' }; $dispatch('open-modal', 'delete-product-modal'); $el.closest('[x-data]').__x.$data.open = false;">
                                                    {{ __('admin/components.buttons.delete') }}
                                                </x-dropdown-item>
                                            </x-dropdown-menu>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        @else
                            <x-table.row>
                                <x-table.cell colspan="11" class="text-center py-8 text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>

            
            <x-filter-sidebar id="products-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">
                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/products.fields.status') }}</label>
                        <x-select name="filter[status]" class="w-full" :value="request()->query('filter.status')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            @foreach(\App\Enums\Database\ProductStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ request()->query('filter.status') === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>

                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/products.fields.is_published') }}</label>
                        <x-select name="filter[is_published]" class="w-full" :value="request()->query('filter.is_published')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_published') === '1' ? 'selected' : '' }}>
                                {{ __('admin/products.statuses.active') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_published') === '0' ? 'selected' : '' }}>
                                {{ __('admin/products.statuses.inactive') }}
                            </option>
                        </x-select>
                    </div>

                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/products.fields.category') }}</label>
                        <x-select name="filter[category_id]" class="w-full" :value="request()->query('filter.category_id')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="null" {{ request()->query('filter.category_id') === 'null' ? 'selected' : '' }}>
                                {{ __('admin/products.forms.placeholders.no_category') }}
                            </option>
                            @forelse(($categories ?? []) as $category)
                                <option value="{{ $category->id }}"
                                    {{ request()->query('filter.category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @empty
                                <option value="" disabled>{{ __('admin/components.status.no_results') }}</option>
                            @endforelse
                        </x-select>
                    </div>

                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/products.fields.unit') }}</label>
                        <x-select name="filter[unit]" class="w-full" :value="request()->query('filter.unit')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            @foreach(\App\Enums\Database\ProductUnit::cases() as $unit)
                                <option value="{{ $unit->value }}" {{ request()->query('filter.unit') === $unit->value ? 'selected' : '' }}>
                                    {{ $unit->label() }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>

        
        <x-delete-confirmation-modal id="delete-product-modal" route-name="admin.products.destroy"
            row-selector="tr[data-product-id='__ID__']" />
    </div>

</x-layouts.admin>
