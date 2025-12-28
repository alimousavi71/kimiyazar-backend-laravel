<x-layouts.admin :title="__('admin/menus.title')" :header-title="__('admin/menus.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/menus.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/menus.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/menus.description') }}</p>
            </div>
            <a href="{{ route('admin.menus.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/menus.add_new') }}
                </x-button>
            </a>
        </div>

        
        <x-session-messages />

        
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="menus-filters" :paginator="$menus ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="name">{{ __('admin/menus.fields.name') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/menus.fields.links_count') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/menus.fields.created_at') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="updated_at">{{ __('admin/menus.fields.updated_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($menus) && $menus->count() > 0)
                            @foreach($menus as $menu)
                                <x-table.row data-menu-id="{{ $menu->id }}">
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $menu->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ $menu->name }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ count($menu->links ?? []) }}
                                            {{ __('admin/menus.links') }}</span>
                                    </x-table.cell>
                                    <x-table.cell>{{ $menu->created_at->format('Y-m-d H:i') }}</x-table.cell>
                                    <x-table.cell>{{ $menu->updated_at->format('Y-m-d H:i') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.menus.show', $menu->id) }}" icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.menus.edit', $menu->id) }}" icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $menu->id }}, name: '{{ addslashes($menu->name) }}' }; $dispatch('open-modal', 'delete-menu-modal'); $el.closest('[x-data]').__x.$data.open = false;">
                                                    {{ __('admin/components.buttons.delete') }}
                                                </x-dropdown-item>
                                            </x-dropdown-menu>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        @else
                            <x-table.row>
                                <x-table.cell colspan="6" class="text-center py-8 text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>
        </x-card>

        
        <x-delete-confirmation-modal id="delete-menu-modal" route-name="admin.menus.destroy"
            row-selector="tr[data-menu-id='__ID__']" />
    </div>

</x-layouts.admin>