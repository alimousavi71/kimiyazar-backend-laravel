<x-layouts.user-profile :title="__('user/profile.forms.edit.title')"
    :header-title="__('user/profile.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile.breadcrumbs.profile'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile.breadcrumbs.edit')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('user/profile.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('user/profile.forms.edit.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('user/profile.forms.edit.card_title') }}</x-slot>

        <form id="profile-edit-form" action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('user/profile.fields.first_name')" required
                    :error="$errors->first('first_name')">
                    <x-input type="text" name="first_name" id="first_name"
                        :placeholder="__('user/profile.forms.placeholders.first_name')"
                        value="{{ old('first_name', $user->first_name) }}" required class="w-full" />
                </x-form-group>

                <x-form-group :label="__('user/profile.fields.last_name')" required
                    :error="$errors->first('last_name')">
                    <x-input type="text" name="last_name" id="last_name"
                        :placeholder="__('user/profile.forms.placeholders.last_name')"
                        value="{{ old('last_name', $user->last_name) }}" required class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('user/profile.fields.email')" required :error="$errors->first('email')">
                <div class="flex gap-2">
                    <x-input type="email" name="email" id="email"
                        :placeholder="__('user/profile.forms.placeholders.email')"
                        value="{{ old('email', $user->email) }}" required readonly
                        class="w-full bg-gray-50 cursor-not-allowed flex-1" />
                    <a href="{{ route('user.profile.email.edit') }}">
                        <x-button variant="secondary" type="button" size="md">
                            {{ __('user/profile.forms.edit.change_email') }}
                        </x-button>
                    </a>
                </div>
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('user/profile.fields.phone_number')" :error="$errors->first('phone_number')">
                    <div class="flex gap-2">
                        <x-input type="text" name="phone_number" id="phone_number"
                            :placeholder="__('user/profile.forms.placeholders.phone_number')"
                            value="{{ old('phone_number', $user->getFullPhoneNumber() ?? $user->phone_number) }}"
                            readonly class="w-full bg-gray-50 cursor-not-allowed flex-1" />
                        <a href="{{ route('user.profile.phone.edit') }}">
                            <x-button variant="secondary" type="button" size="md">
                                {{ __('user/profile.forms.edit.change_phone') }}
                            </x-button>
                        </a>
                    </div>
                </x-form-group>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('user.profile.show') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('user/profile.forms.edit.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.user-profile>