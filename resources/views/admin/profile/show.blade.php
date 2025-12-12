<x-layouts.admin :title="__('admin/profile.show.title')" :header-title="__('admin/profile.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/profile.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/profile.breadcrumbs.profile')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/profile.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/profile.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.profile.edit') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/profile.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.profile.password.edit') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/profile.forms.password.title') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/profile.show.personal_info') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.first_name') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $admin->first_name }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.last_name') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $admin->last_name }}</p>
                        </div>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.full_name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $admin->full_name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.email') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $admin->email }}</p>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot name="title">{{ __('admin/profile.show.activity_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.last_login') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($admin->last_login)
                                {{ $admin->last_login->format('Y-m-d H:i:s') }}
                            @else
                                <span class="text-gray-400">{{ __('admin/profile.show.labels.never_logged_in') }}</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/profile.show.labels.email_verified') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($admin->email_verified_at)
                                <x-badge variant="success"
                                    size="sm">{{ __('admin/profile.show.labels.verified') }}</x-badge>
                                <span
                                    class="text-sm text-gray-500 ml-2">{{ $admin->email_verified_at->format('Y-m-d H:i:s') }}</span>
                            @else
                                <x-badge variant="warning"
                                    size="sm">{{ __('admin/profile.show.labels.not_verified') }}</x-badge>
                            @endif
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.created_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $admin->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.updated_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $admin->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Two-Factor Authentication -->
            <x-card>
                <x-slot name="title">{{ __('admin/auth.two_factor.title') }}</x-slot>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg {{ $twoFactorEnabled ? 'bg-green-100' : 'bg-gray-100' }}">
                                <x-icon name="{{ $twoFactorEnabled ? 'check-circle' : 'x-circle' }}" size="md"
                                    class="{{ $twoFactorEnabled ? 'text-green-600' : 'text-gray-400' }}" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ __('admin/auth.two_factor.status') }}
                                </p>
                                <p class="text-xs text-gray-600">
                                    {{ $twoFactorEnabled ? __('admin/auth.two_factor.enabled') : __('admin/auth.two_factor.disabled') }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="px-3 py-1 rounded-full text-xs font-medium {{ $twoFactorEnabled ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $twoFactorEnabled ? __('admin/components.status.active') : __('admin/components.status.inactive') }}
                        </div>
                    </div>

                    <a href="{{ route('admin.two-factor.status') }}">
                        <x-button variant="secondary" size="md" class="w-full">
                            <x-icon name="shield" size="sm" class="me-2" />
                            {{ __('admin/auth.two_factor.manage_button') }}
                        </x-button>
                    </a>
                </div>
            </x-card>
        </div>

        <!-- Avatar Section -->
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/profile.show.avatar_card_title') }}</x-slot>

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