<x-layouts.admin :title="__('admin/categories.title')" :header-title="__('admin/categories.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/categories.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/categories.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/categories.description') }}</p>
            </div>
            <a href="{{ route('admin.categories.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/categories.add_new') }}
                </x-button>
            </a>
        </div>

        
        <x-session-messages />

        @php
            $rootCategories = $rootCategories ?? collect();
        @endphp

        
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="categories-filters" :filter-badges="[
                'is_active' => __('admin/categories.fields.is_active'),
                'is_root' => __('admin/categories.fields.is_root'),
                'parent_id' => __('admin/categories.fields.parent'),
            ]" :paginator="$categories ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="name">{{ __('admin/categories.fields.name') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="slug">{{ __('admin/categories.fields.slug') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="parent_id">{{ __('admin/categories.fields.parent') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_active">{{ __('admin/categories.fields.is_active') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="sort_order">{{ __('admin/categories.fields.sort_order') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/categories.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories as $category)
                                <x-table.row data-category-id="{{ $category->id }}">
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $category->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ $category->name }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-700">{{ $category->slug }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($category->parent)
                                            <span class="text-gray-700">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="text-gray-400">{{ __('admin/categories.status.root') }}</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($category->is_active)
                                            <x-badge variant="success" size="sm">{{ __('admin/categories.status.active') }}</x-badge>
                                        @else
                                            <x-badge variant="danger" size="sm">{{ __('admin/categories.status.inactive') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <input 
                                            type="number" 
                                            min="0"
                                            value="{{ $category->sort_order }}" 
                                            data-category-id="{{ $category->id }}"
                                            class="category-sort-order-input w-20 px-2 py-1 text-sm text-gray-900 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all"
                                            data-original-value="{{ $category->sort_order }}"
                                        />
                                    </x-table.cell>
                                    <x-table.cell>{{ $category->created_at->format('Y-m-d') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.categories.show', $category->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.categories.edit', $category->id) }}"
                                                    icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $category->id }}, name: '{{ addslashes($category->name) }}' }; $dispatch('open-modal', 'delete-category-modal'); $el.closest('[x-data]').__x.$data.open = false;">
                                                    {{ __('admin/components.buttons.delete') }}
                                                </x-dropdown-item>
                                            </x-dropdown-menu>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        @else
                            <x-table.row>
                                <x-table.cell colspan="7" class="text-center py-8 text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>

            
            <x-filter-sidebar id="categories-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">
                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/categories.fields.is_active') }}</label>
                        <x-select name="filter[is_active]" class="w-full" :value="request()->query('filter.is_active')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_active') === '1' ? 'selected' : '' }}>
                                {{ __('admin/categories.status.active') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_active') === '0' ? 'selected' : '' }}>
                                {{ __('admin/categories.status.inactive') }}
                            </option>
                        </x-select>
                    </div>

                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/categories.fields.is_root') }}</label>
                        <x-select name="filter[is_root]" class="w-full" :value="request()->query('filter.is_root')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_root') === '1' ? 'selected' : '' }}>
                                {{ __('admin/categories.status.root') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_root') === '0' ? 'selected' : '' }}>
                                {{ __('admin/categories.status.has_parent') }}
                            </option>
                        </x-select>
                    </div>

                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/categories.fields.parent') }}</label>
                        <x-select name="filter[parent_id]" class="w-full" :value="request()->query('filter.parent_id')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            @forelse(($rootCategories ?? []) as $rootCategory)
                                <option value="{{ $rootCategory->id }}"
                                    {{ request()->query('filter.parent_id') == $rootCategory->id ? 'selected' : '' }}>
                                    {{ $rootCategory->name }}
                                </option>
                            @empty
                                <option value="" disabled>{{ __('admin/components.status.no_results') }}</option>
                            @endforelse
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>

        
        <x-delete-confirmation-modal id="delete-category-modal" route-name="admin.categories.destroy"
            row-selector="tr[data-category-id='__ID__']" />
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Simple route template approach (like product-price-management.js)
                const adminPrefix = '{{ config("admin.prefix", "admin") }}';
                const updateSortOrderRouteTemplate = `/${adminPrefix}/categories/__CATEGORY_ID__/sort-order`;
                
                function getUpdateSortOrderRoute(categoryId) {
                    return updateSortOrderRouteTemplate.replace('__CATEGORY_ID__', categoryId);
                }
                
                const sortOrderInputs = document.querySelectorAll('.category-sort-order-input');

                sortOrderInputs.forEach(input => {
                    // Handle blur event (when user leaves the input)
                    input.addEventListener('blur', function () {
                        const categoryId = this.getAttribute('data-category-id');
                        const newValue = parseInt(this.value) || 0;
                        const originalValue = parseInt(this.getAttribute('data-original-value')) || 0;

                        // Only update if value changed and categoryId is valid
                        if (categoryId && newValue !== originalValue) {
                            updateSortOrder(categoryId, newValue, this);
                        } else {
                            // Reset to original if invalid
                            this.value = originalValue;
                        }
                    });

                    // Handle Enter key
                    input.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            this.blur();
                        }
                    });
                });

                async function updateSortOrder(categoryId, sortOrder, inputElement) {
                    // Validate categoryId
                    if (!categoryId) {
                        console.error('Category ID is missing');
                        return;
                    }

                    // Disable input during update
                    inputElement.disabled = true;
                    const originalValue = inputElement.getAttribute('data-original-value');

                    try {
                        const url = getUpdateSortOrderRoute(categoryId);
                        const response = await window.axios.post(url, {
                            sort_order: sortOrder
                        });

                        if (response.data && response.data.success !== false) {
                            // Update original value attribute
                            inputElement.setAttribute('data-original-value', sortOrder);
                        } else {
                            // Revert on failure
                            inputElement.value = originalValue;
                        }
                    } catch (error) {
                        console.error('Update sort order error:', error);
                        // Revert to original value on error
                        inputElement.value = originalValue;
                    } finally {
                        // Re-enable input
                        inputElement.disabled = false;
                    }
                }
            });
        </script>
    @endpush

</x-layouts.admin>

