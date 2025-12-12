<x-layouts.admin title="Create Admin" header-title="Create Admin" :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Admins', 'url' => route('admin.admins.index')],
        ['label' => 'Create']
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Create New Admin</h2>
        <p class="text-xs text-gray-600 mt-0.5">Add a new administrator to the system</p>
    </div>

    <x-card>
        <x-slot name="title">Admin Information</x-slot>

        <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group label="First Name" required :error="$errors->first('first_name')">
                    <x-input type="text" name="first_name" id="first_name" placeholder="Enter first name"
                        value="{{ old('first_name') }}" required class="w-full" />
                </x-form-group>

                <x-form-group label="Last Name" required :error="$errors->first('last_name')">
                    <x-input type="text" name="last_name" id="last_name" placeholder="Enter last name"
                        value="{{ old('last_name') }}" required class="w-full" />
                </x-form-group>
            </div>

            <x-form-group label="Email Address" required :error="$errors->first('email')">
                <x-input type="email" name="email" id="email" placeholder="Enter email address"
                    value="{{ old('email') }}" required class="w-full" />
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group label="Password" required :error="$errors->first('password')">
                    <x-input type="password" name="password" id="password" placeholder="Enter password" required
                        class="w-full" />
                </x-form-group>

                <x-form-group label="Confirm Password" required>
                    <x-input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirm password" required class="w-full" />
                </x-form-group>
            </div>

            <x-form-group label="Status">
                <x-toggle name="is_block" id="is_block" :checked="old('is_block', false)" label="Block this admin" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.admins.index') }}">
                    <x-button variant="secondary" type="button">
                        Cancel
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    Create Admin
                </x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>