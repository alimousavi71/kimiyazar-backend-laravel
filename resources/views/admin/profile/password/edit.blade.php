<x-layouts.admin :title="__('admin/profile.forms.password.title')"
    :header-title="__('admin/profile.forms.password.header_title')" :breadcrumbs="[
        ['label' => __('admin/profile.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/profile.breadcrumbs.profile'), 'url' => route('admin.profile.show')],
        ['label' => __('admin/profile.breadcrumbs.password')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/profile.forms.password.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/profile.forms.password.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/profile.forms.password.card_title') }}</x-slot>

        <form id="profile-password-form" action="{{ route('admin.profile.password.update') }}" method="POST"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/admins.fields.password')" required :error="$errors->first('password')">
                    <x-input type="password" name="password" id="password"
                        :placeholder="__('admin/admins.forms.placeholders.new_password')" required class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/admins.fields.password_confirmation')" required>
                    <x-input type="password" name="password_confirmation" id="password_confirmation"
                        :placeholder="__('admin/admins.forms.placeholders.confirm_new_password')" required
                        class="w-full" />
                </x-form-group>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.profile.show') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/profile.forms.password.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-password-validation.js')
    @endpush
</x-layouts.admin>