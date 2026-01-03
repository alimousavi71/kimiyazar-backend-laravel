<x-layouts.admin :title="__('admin/banners.title')" :header-title="__('admin/banners.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/banners.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/banners.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/banners.description') }}</p>
            </div>
            <a href="{{ route('admin.banners.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/banners.add_new') }}
                </x-button>
            </a>
        </div>


        <x-session-messages />


        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="banners-filters" :filter-badges="[
                'position' => __('admin/banners.fields.position'),
                'is_active' => __('admin/banners.fields.is_active'),
            ]" :paginator="$banners ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="name">{{ __('admin/banners.fields.name') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="position">{{ __('admin/banners.fields.position') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/banners.fields.banner_file') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_active">{{ __('admin/banners.fields.is_active') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/banners.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($banners) && $banners->count() > 0)
                            @foreach($banners as $banner)
                                <x-table.row data-banner-id="{{ $banner->id }}">
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $banner->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ $banner->name }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <x-badge variant="info" size="sm">{{ $banner->position->value }}</x-badge>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($banner->banner_file)
                                            <img src="{{ asset('storage/' . $banner->banner_file) }}" alt="{{ $banner->name }}"
                                                class="w-16 h-10 object-cover rounded">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($banner->is_active)
                                            <x-badge variant="success" size="sm">{{ __('admin/banners.status.active') }}</x-badge>
                                        @else
                                            <x-badge variant="danger" size="sm">{{ __('admin/banners.status.inactive') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell><x-date :date="$banner->created_at" type="date" /></x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.banners.show', $banner->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.banners.edit', $banner->id) }}"
                                                    icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $banner->id }}, name: '{{ addslashes($banner->name) }}' }; $dispatch('open-modal', 'delete-banner-modal'); $el.closest('[x-data]').__x.$data.open = false;">
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


            <x-filter-sidebar id="banners-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/banners.fields.position') }}</label>
                        <x-select name="filter[position]" class="w-full" :value="request()->query('filter.position')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            @foreach(\App\Enums\Database\BannerPosition::cases() as $position)
                                <option value="{{ $position->value }}" {{ request()->query('filter.position') === $position->value ? 'selected' : '' }}>
                                    {{ $position->value }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>


                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/banners.fields.is_active') }}</label>
                        <x-select name="filter[is_active]" class="w-full" :value="request()->query('filter.is_active')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_active') === '1' ? 'selected' : '' }}>
                                {{ __('admin/banners.status.active') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_active') === '0' ? 'selected' : '' }}>
                                {{ __('admin/banners.status.inactive') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>


        <x-delete-confirmation-modal id="delete-banner-modal" route-name="admin.banners.destroy"
            row-selector="tr[data-banner-id='__ID__']" />
    </div>

</x-layouts.admin>