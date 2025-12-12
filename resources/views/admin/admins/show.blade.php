<x-layouts.admin :title="__('admin/admins.show.title')" :header-title="__('admin/admins.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/admins.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/admins.forms.breadcrumbs.admins'), 'url' => route('admin.admins.index')],
        ['label' => __('admin/admins.forms.breadcrumbs.details')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/admins.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/admins.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.admins.edit', $admin->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/admins.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.admins.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/admins.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/admins.show.personal_info') }}</x-slot>

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

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.is_block') }}</label>
                        <div class="mt-1">
                            @if($admin->is_block)
                                <x-badge variant="danger" size="md">{{ __('admin/admins.status.blocked') }}</x-badge>
                            @else
                                <x-badge variant="success" size="md">{{ __('admin/admins.status.active') }}</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot name="title">{{ __('admin/admins.show.activity_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/admins.fields.last_login') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($admin->last_login)
                                {{ $admin->last_login->format('Y-m-d H:i:s') }}
                            @else
                                <span class="text-gray-400">{{ __('admin/admins.show.labels.never_logged_in') }}</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/admins.show.labels.email_verified') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($admin->email_verified_at)
                                <x-badge variant="success" size="sm">{{ __('admin/admins.show.labels.verified') }}</x-badge>
                                <span
                                    class="text-sm text-gray-500 ml-2">{{ $admin->email_verified_at->format('Y-m-d H:i:s') }}</span>
                            @else
                                <x-badge variant="warning"
                                    size="sm">{{ __('admin/admins.show.labels.not_verified') }}</x-badge>
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
        </div>

        <!-- Avatar Section -->
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/admins.show.avatar_card_title') }}</x-slot>

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