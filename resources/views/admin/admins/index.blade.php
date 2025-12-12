<x-layouts.admin :title="__('admin/admins.title')" :header-title="__('admin/admins.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/admins.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/admins.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/admins.description') }}</p>
            </div>
            <a href="{{ route('admin.admins.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/admins.add_new') }}
                </x-button>
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <x-alert type="success" dismissible>
                {{ session('success') }}
            </x-alert>
        @endif

        @if(session('error'))
            <x-alert type="danger" dismissible>
                {{ session('error') }}
            </x-alert>
        @endif

        <!-- Admins Table -->
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="admins-filters" :filter-badges="[
                'is_block' => __('admin/admins.fields.is_block'),
            ]" :paginator="$admins ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="first_name">{{ __('admin/admins.fields.full_name') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="email">{{ __('admin/admins.fields.email') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_block">{{ __('admin/admins.fields.is_block') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="last_login">{{ __('admin/admins.fields.last_login') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/admins.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($admins) && $admins->count() > 0)
                            @foreach($admins as $admin)
                                <x-table.row data-admin-id="{{ $admin->id }}">
                                    <x-table.cell>
                                        <div class="flex items-center gap-3">
                                            @if($admin->avatar)
                                                <img src="{{ asset('storage/' . $admin->avatar) }}" alt="{{ $admin->full_name }}"
                                                    class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span
                                                        class="text-blue-600 font-semibold text-xs">{{ strtoupper(substr($admin->first_name, 0, 1) . substr($admin->last_name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                            <span class="font-medium text-gray-900">{{ $admin->full_name }}</span>
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>{{ $admin->email }}</x-table.cell>
                                    <x-table.cell>
                                        @if($admin->is_block)
                                            <x-badge variant="danger" size="sm">{{ __('admin/admins.status.blocked') }}</x-badge>
                                        @else
                                            <x-badge variant="success" size="sm">{{ __('admin/admins.status.active') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($admin->last_login)
                                            {{ $admin->last_login->format('Y-m-d H:i') }}
                                        @else
                                            <span class="text-gray-400">{{ __('admin/admins.status.never') }}</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>{{ $admin->created_at->format('Y-m-d') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.admins.show', $admin->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.admins.edit', $admin->id) }}"
                                                    icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.admins.password.edit', $admin->id) }}"
                                                    icon="lock" variant="primary">
                                                    {{ __('admin/admins.forms.password.title') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $admin->id }}, name: '{{ addslashes($admin->full_name) }}' }; $dispatch('open-modal', 'delete-admin-modal'); $el.closest('[x-data]').__x.$data.open = false;">
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

            <!-- Filter Sidebar -->
            <x-filter-sidebar id="admins-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">
                    <!-- Status Filter -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/admins.fields.is_block') }}</label>
                        <x-select name="filter[is_block]" class="w-full" :value="request()->query('filter.is_block')">
                            <option value="">{{ __('admin/components.status.active') }} /
                                {{ __('admin/components.status.blocked') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_block') === '0' ? 'selected' : '' }}>
                                {{ __('admin/admins.status.active') }}
                            </option>
                            <option value="1" {{ request()->query('filter.is_block') === '1' ? 'selected' : '' }}>
                                {{ __('admin/admins.status.blocked') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>

        <!-- Delete Confirmation Modal -->
        <x-delete-confirmation-modal id="delete-admin-modal" route-name="admin.admins.destroy"
            row-selector="tr[data-admin-id='__ID__']" />
    </div>

</x-layouts.admin>