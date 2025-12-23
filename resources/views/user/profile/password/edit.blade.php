<x-layouts.user-profile :title="__('user/profile.forms.password.title')"
    :header-title="__('user/profile.forms.password.header_title')" :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile.breadcrumbs.profile'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile.breadcrumbs.password')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('user/profile.forms.password.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('user/profile.forms.password.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('user/profile.forms.password.card_title') }}</x-slot>

        <form id="password-edit-form" action="{{ route('user.profile.password.update') }}" method="POST"
            class="space-y-6">
            @csrf
            @method('PUT')

            <x-form-group :label="__('user/profile.forms.password.current_password')" required
                :error="$errors->first('current_password')">
                <x-input type="password" name="current_password" id="current_password"
                    :placeholder="__('user/profile.forms.password.placeholders.current_password')" required
                    class="w-full" autocomplete="current-password" />
            </x-form-group>

            <x-form-group :label="__('user/profile.forms.password.new_password')" required
                :error="$errors->first('password')">
                <x-input type="password" name="password" id="password"
                    :placeholder="__('user/profile.forms.password.placeholders.new_password')" required class="w-full"
                    autocomplete="new-password" />
            </x-form-group>

            <x-form-group :label="__('user/profile.forms.password.confirm_password')" required
                :error="$errors->first('password_confirmation')">
                <x-input type="password" name="password_confirmation" id="password_confirmation"
                    :placeholder="__('user/profile.forms.password.placeholders.confirm_password')" required
                    class="w-full" autocomplete="new-password" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('user.profile.show') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('user/profile.forms.password.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-password-validation.js')
    @endpush
</x-layouts.user-profile>