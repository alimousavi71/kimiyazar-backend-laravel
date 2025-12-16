<x-layouts.admin :title="__('admin/sliders.title')" :header-title="__('admin/sliders.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/sliders.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/sliders.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/sliders.description') }}</p>
            </div>
            <a href="{{ route('admin.sliders.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/sliders.add_new') }}
                </x-button>
            </a>
        </div>

        <!-- Success/Error Messages -->
        <x-session-messages />

        <!-- Sliders Table -->
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="sliders-filters" :filter-badges="[
                'is_active' => __('admin/sliders.fields.is_active'),
            ]" :paginator="$sliders ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="title">{{ __('admin/sliders.fields.title') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/sliders.fields.heading') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/photos.title') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="sort_order">{{ __('admin/sliders.fields.sort_order') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_active">{{ __('admin/sliders.fields.is_active') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/sliders.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($sliders) && $sliders->count() > 0)
                            @foreach($sliders as $slider)
                                <x-table.row data-slider-id="{{ $slider->id }}">
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ $slider->title }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $slider->heading ?? '-' }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @php
                                            $primaryPhoto = $slider->primaryPhoto();
                                        @endphp
                                        @if($primaryPhoto)
                                            <img src="{{ $primaryPhoto->url }}" alt="{{ $slider->title }}"
                                                class="w-16 h-10 object-cover rounded">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $slider->sort_order }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($slider->is_active)
                                            <x-badge variant="success" size="sm">{{ __('admin/sliders.status.active') }}</x-badge>
                                        @else
                                            <x-badge variant="danger" size="sm">{{ __('admin/sliders.status.inactive') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>{{ $slider->created_at->format('Y-m-d') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.sliders.show', $slider->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.sliders.edit', $slider->id) }}"
                                                    icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $slider->id }}, name: '{{ addslashes($slider->title) }}' }; $dispatch('open-modal', 'delete-slider-modal'); $el.closest('[x-data]').__x.$data.open = false;">
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

            <!-- Filter Sidebar -->
            <x-filter-sidebar id="sliders-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">
                    <!-- Status Filter -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/sliders.fields.is_active') }}</label>
                        <x-select name="filter[is_active]" class="w-full" :value="request()->query('filter.is_active')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_active') === '1' ? 'selected' : '' }}>
                                {{ __('admin/sliders.status.active') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_active') === '0' ? 'selected' : '' }}>
                                {{ __('admin/sliders.status.inactive') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>

        <!-- Delete Confirmation Modal -->
        <x-delete-confirmation-modal id="delete-slider-modal" route-name="admin.sliders.destroy"
            row-selector="tr[data-slider-id='__ID__']" />
    </div>

</x-layouts.admin>

