<x-layouts.admin :title="__('admin/modals.title')" :header-title="__('admin/modals.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/modals.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/modals.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/modals.description') }}</p>
            </div>
            <a href="{{ route('admin.modals.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/modals.add_new') }}
                </x-button>
            </a>
        </div>

        
        <x-session-messages />

        
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="modals-filters" :filter-badges="[
                'is_published' => __('admin/modals.fields.is_published'),
            ]" :paginator="$modals ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="title">{{ __('admin/modals.fields.title') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/modals.fields.content') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="priority">{{ __('admin/modals.fields.priority') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_published">{{ __('admin/modals.fields.is_published') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="start_at">{{ __('admin/modals.fields.start_at') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="end_at">{{ __('admin/modals.fields.end_at') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/modals.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($modals) && $modals->count() > 0)
                            @foreach($modals as $modal)
                                <x-table.row data-modal-id="{{ $modal->id }}">
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $modal->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ $modal->title }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span
                                            class="text-gray-600 truncate max-w-xs">{{ Str::limit($modal->content, 50) }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $modal->priority }}
                                        </span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($modal->is_published)
                                            <x-badge variant="success" size="sm">{{ __('admin/modals.status.active') }}</x-badge>
                                        @else
                                            <x-badge variant="danger" size="sm">{{ __('admin/modals.status.inactive') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $modal->start_at?->format('Y-m-d H:i') ?? '-' }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $modal->end_at?->format('Y-m-d H:i') ?? '-' }}</span>
                                    </x-table.cell>
                                    <x-table.cell>{{ $modal->created_at->format('Y-m-d') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.modals.show', $modal->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.modals.edit', $modal->id) }}"
                                                    icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $modal->id }}, name: '{{ addslashes($modal->title) }}' }; $dispatch('open-modal', 'delete-modal-modal'); $el.closest('[x-data]').__x.$data.open = false;">
                                                    {{ __('admin/components.buttons.delete') }}
                                                </x-dropdown-item>
                                            </x-dropdown-menu>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        @else
                            <x-table.row>
                                <x-table.cell colspan="9" class="text-center py-8 text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>

            
            <x-filter-sidebar id="modals-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">
                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/modals.fields.is_published') }}</label>
                        <x-select name="filter[is_published]" class="w-full"
                            :value="request()->query('filter.is_published')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_published') === '1' ? 'selected' : '' }}>
                                {{ __('admin/modals.status.active') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_published') === '0' ? 'selected' : '' }}>
                                {{ __('admin/modals.status.inactive') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>

        
        <x-delete-confirmation-modal id="delete-modal-modal" route-name="admin.modals.destroy"
            row-selector="tr[data-modal-id='__ID__']" />
    </div>

</x-layouts.admin>