<x-layouts.admin title="Admins" header-title="Admins" :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Admins']
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Admin Management</h2>
                <p class="text-xs text-gray-600 mt-0.5">Manage all administrators in the system</p>
            </div>
            <a href="{{ route('admin.admins.create') }}">
                <x-button variant="primary" size="md">
                    Add New Admin
                </x-button>
            </a>
        </div>

        <!-- Admins Table -->
        <x-card>
            <x-table-wrapper search-placeholder="Search admins by name, email..." filter-sidebar-id="admins-filters"
                :filter-badges="[
                'is_block' => 'Status',
            ]" :paginator="$admins ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable sort-field="first_name">Name</x-table.cell>
                            <x-table.cell header sortable sort-field="email">Email</x-table.cell>
                            <x-table.cell header sortable sort-field="is_block">Status</x-table.cell>
                            <x-table.cell header sortable sort-field="last_login">Last Login</x-table.cell>
                            <x-table.cell header sortable sort-field="created_at">Created</x-table.cell>
                            <x-table.cell header class="text-end">Actions</x-table.cell>
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
                                            <x-badge variant="danger" size="sm">Blocked</x-badge>
                                        @else
                                            <x-badge variant="success" size="sm">Active</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($admin->last_login)
                                            {{ $admin->last_login->format('Y-m-d H:i') }}
                                        @else
                                            <span class="text-gray-400">Never</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>{{ $admin->created_at->format('Y-m-d') }}</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.admins.show', $admin->id) }}">
                                                <x-button variant="secondary" size="sm">View</x-button>
                                            </a>
                                            <a href="{{ route('admin.admins.edit', $admin->id) }}">
                                                <x-button variant="primary" size="sm">Edit</x-button>
                                            </a>
                                            <x-button variant="danger" size="sm" type="button" x-data
                                                @click="window.deleteData = { id: {{ $admin->id }}, name: '{{ addslashes($admin->full_name) }}' }; $dispatch('open-modal', 'delete-admin-modal');">
                                                Delete
                                            </x-button>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        @else
                            <x-table.row>
                                <x-table.cell colspan="6" class="text-center py-8 text-gray-500">
                                    No admins found
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>

            <!-- Filter Sidebar -->
            <x-filter-sidebar id="admins-filters" title="Filter Admins" method="GET" action="{{ request()->url() }}">
                <div class="space-y-6">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <x-select name="filter[is_block]" class="w-full" :value="request()->query('filter.is_block')">
                            <option value="">All Statuses</option>
                            <option value="0" {{ request()->query('filter.is_block') === '0' ? 'selected' : '' }}>Active
                            </option>
                            <option value="1" {{ request()->query('filter.is_block') === '1' ? 'selected' : '' }}>Blocked
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