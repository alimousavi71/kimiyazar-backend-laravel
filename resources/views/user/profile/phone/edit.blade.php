<x-layouts.user-profile :title="__('user/profile/phone.forms.edit.title')"
    :header-title="__('user/profile/phone.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile.breadcrumbs.profile'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile/phone.forms.edit.title')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('user/profile/phone.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('user/profile/phone.forms.edit.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('user/profile/phone.forms.edit.card_title') }}</x-slot>

        <div class="space-y-4 mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <x-icon name="info-circle" size="md" class="text-blue-600 mt-0.5" />
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">{{ __('user/profile/phone.forms.edit.current_phone') }}</p>
                        <p class="text-blue-900">
                            {{ $user->getFullPhoneNumber() ?? $user->phone_number ?? __('user/profile/phone.forms.edit.no_phone') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form id="phone-edit-form" action="{{ route('user.profile.phone.send-otp') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('user/profile/phone.forms.edit.country_code')"
                    :error="$errors->first('country_code')">
                    <x-input type="text" name="country_code" id="country_code"
                        :placeholder="__('user/profile/phone.forms.edit.placeholder_country_code')"
                        value="{{ old('country_code', $user->country_code) }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('user/profile/phone.forms.edit.phone_number')" required
                    :error="$errors->first('phone_number')">
                    <x-input type="text" name="phone_number" id="phone_number"
                        :placeholder="__('user/profile/phone.forms.edit.placeholder_phone_number')"
                        value="{{ old('phone_number') }}" required class="w-full" />
                </x-form-group>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('user.profile.show') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('user/profile/phone.forms.edit.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.user-profile>