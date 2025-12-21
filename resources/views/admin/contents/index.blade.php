<x-layouts.admin :title="__('admin/contents.title')" :header-title="__('admin/contents.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/contents.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/contents.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/contents.description') }}</p>
            </div>
            <a href="{{ route('admin.contents.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/contents.add_new') }}
                </x-button>
            </a>
        </div>

        <!-- Success/Error Messages -->
        <x-session-messages />

        <!-- Contents Table -->
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="contents-filters" :filter-badges="[
                'type' => __('admin/contents.fields.type'),
                'is_active' => __('admin/contents.fields.is_active'),
            ]" :paginator="$contents ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="title">{{ __('admin/contents.fields.title') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="type">{{ __('admin/contents.fields.type') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="visit_count">{{ __('admin/contents.fields.visit_count') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_active">{{ __('admin/contents.fields.is_active') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/contents.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($contents) && $contents->count() > 0)
                            @foreach($contents as $content)
                                <x-table.row data-content-id="{{ $content->id }}">
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $content->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ Str::limit($content->title, 50) }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <x-badge variant="info" size="sm">{{ $content->type->label() }}</x-badge>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ number_format($content->visit_count) }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($content->is_active)
                                            <x-badge variant="success" size="sm">{{ __('admin/contents.status.active') }}</x-badge>
                                        @else
                                            <x-badge variant="danger" size="sm">{{ __('admin/contents.status.inactive') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>{{ $content->created_at->format('Y-m-d') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.contents.show', $content->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.contents.edit', $content->id) }}"
                                                    icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                @if(!$content->is_undeletable)
                                                    <div class="border-t border-gray-200 my-1"></div>
                                                    <x-dropdown-item variant="danger" icon="trash" type="button"
                                                        @click.stop="window.deleteData = { id: {{ $content->id }}, name: '{{ addslashes($content->title) }}' }; $dispatch('open-modal', 'delete-content-modal'); $el.closest('[x-data]').__x.$data.open = false;">
                                                        {{ __('admin/components.buttons.delete') }}
                                                    </x-dropdown-item>
                                                @endif
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
            <x-filter-sidebar id="contents-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">
                    <!-- Type Filter -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/contents.fields.type') }}</label>
                        <x-select name="filter[type]" class="w-full" :value="request()->query('filter.type')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            @foreach(\App\Enums\Database\ContentType::cases() as $type)
                                <option value="{{ $type->value }}" {{ request()->query('filter.type') === $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/contents.fields.is_active') }}</label>
                        <x-select name="filter[is_active]" class="w-full" :value="request()->query('filter.is_active')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_active') === '1' ? 'selected' : '' }}>
                                {{ __('admin/contents.status.active') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_active') === '0' ? 'selected' : '' }}>
                                {{ __('admin/contents.status.inactive') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>

        <!-- Delete Confirmation Modal -->
        <x-delete-confirmation-modal id="delete-content-modal" route-name="admin.contents.destroy"
            row-selector="tr[data-content-id='__ID__']" />
    </div>

</x-layouts.admin>