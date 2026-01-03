<x-layouts.admin :title="__('admin/users.show.title')" :header-title="__('admin/users.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/users.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/users.forms.breadcrumbs.users'), 'url' => route('admin.users.index')],
        ['label' => __('admin/users.show.title')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/users.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/users.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/components.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.users.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/components.buttons.back') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/users.show.user_info') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.first_name') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $user->first_name }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.last_name') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $user->last_name }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.email') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            <a href="mailto:{{ $user->email }}"
                                class="text-blue-600 hover:text-blue-700">{{ $user->email }}</a>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.country_code') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $user->country_code ?: '-' }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.phone_number') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $user->phone_number ?: '-' }}</p>
                        </div>
                    </div>

                    @if($user->phone_number && $user->country_code)
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/users.labels.full_phone') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                <a href="tel:{{ $user->getFullPhoneNumber() }}" class="text-blue-600 hover:text-blue-700">
                                    {{ $user->getFullPhoneNumber() }}
                                </a>
                            </p>
                        </div>
                    @endif

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.is_active') }}</label>
                        <div class="mt-1">
                            @if($user->is_active)
                                <x-badge variant="success" size="md">{{ __('admin/users.status.active') }}</x-badge>
                            @else
                                <x-badge variant="danger" size="md">{{ __('admin/users.status.inactive') }}</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot name="title">{{ __('admin/users.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.created_at') }}</label>
                            <p class="text-base text-gray-900 mt-1"><x-date :date="$user->created_at"
                                    type="datetime-full" /></p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.updated_at') }}</label>
                            <p class="text-base text-gray-900 mt-1"><x-date :date="$user->updated_at"
                                    type="datetime-full" /></p>
                        </div>
                    </div>

                    @if($user->last_login)
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.last_login') }}</label>
                            <p class="text-base text-gray-900 mt-1"><x-date :date="$user->last_login"
                                    type="datetime-full" /></p>
                        </div>
                    @endif
                </div>
            </x-card>
        </div>


        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/users.show.quick_actions') }}</x-slot>

                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="block">
                        <x-button variant="primary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.edit') }}
                        </x-button>
                    </a>
                    <a href="{{ route('admin.users.edit-password', $user->id) }}" class="block">
                        <x-button variant="warning" size="sm" class="w-full">
                            {{ __('admin/users.buttons.change_password') }}
                        </x-button>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="block">
                        <x-button variant="secondary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.back') }}
                        </x-button>
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>