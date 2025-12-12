<x-layouts.admin header-title="Users" :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Users']
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">User Management</h2>
            <p class="text-xs text-gray-600 mt-0.5">Manage all users in the system</p>
        </div>
        <x-button variant="primary" size="md" @click="$dispatch('open-modal', 'create-user-modal')">
            Add New User
        </x-button>
    </div>

    <!-- Users Table -->
    <x-card>
        <x-table-wrapper 
            search-placeholder="Search users by name, email..." 
            filter-sidebar-id="users-filters"
            :filter-badges="[
                'role' => 'Role',
                'status' => 'Status',
                'date_from' => 'From Date',
                'date_to' => 'To Date',
                'verified' => 'Verified',
                'email_verified' => 'Email Verified'
            ]"
            :paginator="$paginator ?? null"
        >
            <x-table>
                <x-table.head>
                    <x-table.row>
                        <x-table.cell header sortable sort-field="name">Name</x-table.cell>
                        <x-table.cell header sortable sort-field="email">Email</x-table.cell>
                        <x-table.cell header sortable sort-field="role">Role</x-table.cell>
                        <x-table.cell header sortable sort-field="status">Status</x-table.cell>
                        <x-table.cell header sortable sort-field="created_at">Created</x-table.cell>
                        <x-table.cell header class="text-end">Actions</x-table.cell>
                    </x-table.row>
                </x-table.head>
                <x-table.body>
                    @if(isset($users) && $users->count() > 0)
                        @foreach($users as $user)
                            <x-table.row>
                                <x-table.cell>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold text-xs">{{ strtoupper(substr($user['name'], 0, 2)) }}</span>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $user['name'] }}</span>
                                    </div>
                                </x-table.cell>
                                <x-table.cell>{{ $user['email'] }}</x-table.cell>
                                <x-table.cell>
                                    @if($user['role'] === 'admin')
                                        <x-badge variant="primary" size="sm">Admin</x-badge>
                                    @elseif($user['role'] === 'moderator')
                                        <x-badge variant="info" size="sm">Moderator</x-badge>
                                    @else
                                        <x-badge variant="default" size="sm">User</x-badge>
                                    @endif
                                </x-table.cell>
                                <x-table.cell>
                                    @if($user['status'] === 'active')
                                        <x-badge variant="success" size="sm">Active</x-badge>
                                    @elseif($user['status'] === 'pending')
                                        <x-badge variant="warning" size="sm">Pending</x-badge>
                                    @else
                                        <x-badge variant="danger" size="sm">Inactive</x-badge>
                                    @endif
                                </x-table.cell>
                                <x-table.cell>{{ $user['created'] }}</x-table.cell>
                                <x-table.cell>
                                    <div class="flex items-center justify-end gap-2">
                                        <x-button variant="secondary" size="sm">Edit</x-button>
                                        <x-button variant="danger" size="sm">Delete</x-button>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    @else
                        <x-table.row>
                            <x-table.cell colspan="6" class="text-center py-8 text-gray-500">
                                No users found
                            </x-table.cell>
                        </x-table.row>
                    @endif
                </x-table.body>
            </x-table>
        </x-table-wrapper>

        <!-- Filter Sidebar -->
        <x-filter-sidebar id="users-filters" title="Filter Users" method="GET" action="{{ request()->url() }}">
            <div class="space-y-6">
                <!-- Role Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <x-select name="role" class="w-full" :value="request()->query('role')">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request()->query('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request()->query('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="moderator" {{ request()->query('role') === 'moderator' ? 'selected' : '' }}>Moderator</option>
                    </x-select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <x-select name="status" class="w-full" :value="request()->query('status')">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request()->query('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request()->query('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ request()->query('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </x-select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Created Date</label>
                    <div class="space-y-2">
                        <x-input 
                            type="date" 
                            label="From" 
                            name="date_from" 
                            :value="request()->query('date_from')" 
                        />
                        <x-input 
                            type="date" 
                            label="To" 
                            name="date_to" 
                            :value="request()->query('date_to')" 
                        />
                    </div>
                </div>

                <!-- Additional Options -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Options</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                name="verified"
                                value="1"
                                {{ request()->query('verified') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="text-sm text-gray-700">Verified users only</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                name="email_verified"
                                value="1"
                                {{ request()->query('email_verified') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="text-sm text-gray-700">Has email verified</span>
                        </label>
                    </div>
                </div>
            </div>
        </x-filter-sidebar>
    </x-card>

    <!-- Create User Modal -->
    <x-modal id="create-user-modal" title="Create New User" size="md">
        <form class="space-y-4">
            <x-input label="Full Name" name="name" required />
            <x-input label="Email" type="email" name="email" required />
            <x-input label="Password" type="password" name="password" required />
            <x-select label="Role" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="moderator">Moderator</option>
            </x-select>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <x-button variant="secondary" type="button" @click="$dispatch('close-modal', 'create-user-modal')">
                    Cancel
                </x-button>
                <x-button variant="primary" type="submit">
                    Create User
                </x-button>
            </div>
        </form>
    </x-modal>
</x-layouts.admin>
