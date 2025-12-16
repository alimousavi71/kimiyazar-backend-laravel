<x-layouts.admin :title="__('admin/users.forms.change_password.title')"
    :header-title="__('admin/users.forms.change_password.header_title')" :breadcrumbs="[
        ['label' => __('admin/users.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/users.forms.breadcrumbs.users'), 'url' => route('admin.users.index')],
        ['label' => __('admin/users.forms.breadcrumbs.change_password')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/users.forms.change_password.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/users.forms.change_password.description') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Card -->
        <div class="lg:col-span-2">
            <x-card>
                <x-slot name="title">{{ __('admin/users.forms.change_password.card_title') }}</x-slot>

                <form id="change-password-form" action="{{ route('admin.users.update-password', $user->id) }}" method="POST"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-700">
                            <strong>{{ __('admin/users.labels.changing_password_for') }}:</strong> {{ $user->name }} ({{ $user->email }})
                        </p>
                    </div>

                    <x-form-group :label="__('admin/users.fields.password')" required :error="$errors->first('password')">
                        <x-input type="password" name="password" id="password" :placeholder="__('admin/users.forms.placeholders.new_password')"
                            required class="w-full" />
                        <p class="mt-1 text-xs text-gray-500">{{ __('admin/users.forms.messages.password_requirements') }}</p>
                    </x-form-group>

                    <x-form-group :label="__('admin/users.fields.password_confirmation')" required :error="$errors->first('password_confirmation')">
                        <x-input type="password" name="password_confirmation" id="password_confirmation" :placeholder="__('admin/users.forms.placeholders.confirm_password')"
                            required class="w-full" />
                    </x-form-group>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.users.index') }}">
                            <x-button variant="secondary" type="button">
                                {{ __('admin/components.buttons.cancel') }}
                            </x-button>
                        </a>
                        <x-button variant="primary" type="submit">
                            {{ __('admin/users.forms.change_password.submit') }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Info Sidebar -->
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/users.show.user_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.full_name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->getFullName() }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/users.fields.email') }}</label>
                        <p class="text-base text-gray-900 mt-1 break-all">{{ $user->email }}</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="block">
                            <x-button variant="secondary" size="sm" class="w-full">
                                {{ __('admin/users.buttons.view_profile') }}
                            </x-button>
                        </a>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.admin>
