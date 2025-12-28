<x-layouts.admin :title="__('admin/users.title')" :header-title="__('admin/users.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/users.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/users.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/users.description') }}</p>
            </div>
            <a href="{{ route('admin.users.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/users.add_new') }}
                </x-button>
            </a>
        </div>

        
        <x-session-messages />

        
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="users-filters" :filter-badges="[
                'is_active' => __('admin/users.fields.is_active'),
            ]" :paginator="$users ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="first_name">{{ __('admin/users.fields.full_name') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="email">{{ __('admin/users.fields.email') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/users.fields.phone_number') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_active">{{ __('admin/users.fields.is_active') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/users.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($users) && $users->count() > 0)
                            @foreach($users as $user)
                                <x-table.row data-user-id="{{ $user->id }}">
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $user->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ $user->getFullName() }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600 text-sm">{{ $user->email }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600 text-sm">{{ $user->getFullPhoneNumber() ?? '-' }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($user->is_active)
                                            <x-badge variant="success" size="sm">{{ __('admin/users.status.active') }}</x-badge>
                                        @else
                                            <x-badge variant="danger" size="sm">{{ __('admin/users.status.inactive') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>{{ $user->created_at->format('Y-m-d') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.users.show', $user->id) }}" icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.users.edit', $user->id) }}" icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.users.edit-password', $user->id) }}"
                                                    icon="lock">
                                                    {{ __('admin/users.buttons.change_password') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $user->id }}, name: '{{ addslashes($user->getFullName()) }}' }; $dispatch('open-modal', 'delete-user-modal'); $el.closest('[x-data]').__x.$data.open = false;">
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
                                    {{ __('admin/users.table.empty') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>

            
            <x-filter-sidebar id="users-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">
                    
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/users.fields.is_active') }}</label>
                        <x-select name="filter[is_active]" class="w-full" :value="request()->query('filter.is_active')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_active') === '1' ? 'selected' : '' }}>
                                {{ __('admin/users.status.active') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_active') === '0' ? 'selected' : '' }}>
                                {{ __('admin/users.status.inactive') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>

        
        <x-delete-confirmation-modal id="delete-user-modal" route-name="admin.users.destroy"
            row-selector="tr[data-user-id='__ID__']" />
    </div>

</x-layouts.admin>