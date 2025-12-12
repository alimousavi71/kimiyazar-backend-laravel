<x-layouts.admin title="Admin Details" header-title="Admin Details" :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Admins', 'url' => route('admin.admins.index')],
        ['label' => 'Details']
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Admin Details</h2>
            <p class="text-xs text-gray-600 mt-0.5">View administrator information</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.admins.edit', $admin->id) }}">
                <x-button variant="primary" size="md">
                    Edit Admin
                </x-button>
            </a>
            <a href="{{ route('admin.admins.index') }}">
                <x-button variant="secondary" size="md">
                    Back to List
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">Personal Information</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">First Name</label>
                            <p class="text-base text-gray-900 mt-1">{{ $admin->first_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Last Name</label>
                            <p class="text-base text-gray-900 mt-1">{{ $admin->last_name }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Full Name</label>
                        <p class="text-base text-gray-900 mt-1">{{ $admin->full_name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Email Address</label>
                        <p class="text-base text-gray-900 mt-1">{{ $admin->email }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <div class="mt-1">
                            @if($admin->is_block)
                                <x-badge variant="danger" size="md">Blocked</x-badge>
                            @else
                                <x-badge variant="success" size="md">Active</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot name="title">Activity Information</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Last Login</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($admin->last_login)
                                {{ $admin->last_login->format('Y-m-d H:i:s') }}
                            @else
                                <span class="text-gray-400">Never logged in</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Email Verified</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($admin->email_verified_at)
                                <x-badge variant="success" size="sm">Verified</x-badge>
                                <span
                                    class="text-sm text-gray-500 ml-2">{{ $admin->email_verified_at->format('Y-m-d H:i:s') }}</span>
                            @else
                                <x-badge variant="warning" size="sm">Not Verified</x-badge>
                            @endif
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Created At</label>
                            <p class="text-base text-gray-900 mt-1">{{ $admin->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Updated At</label>
                            <p class="text-base text-gray-900 mt-1">{{ $admin->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Avatar Section -->
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">Avatar</x-slot>

                <div class="flex justify-center">
                    @if($admin->avatar)
                        <img src="{{ asset('storage/' . $admin->avatar) }}" alt="{{ $admin->full_name }}"
                            class="w-40 h-40 rounded-full object-cover border-4 border-gray-200">
                    @else
                        <div class="w-40 h-40 bg-blue-100 rounded-full flex items-center justify-center">
                            <span
                                class="text-blue-600 font-semibold text-4xl">{{ strtoupper(substr($admin->first_name, 0, 1) . substr($admin->last_name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>