<x-layouts.admin :title="__('admin/users.forms.create.title')"
    :header-title="__('admin/users.forms.create.header_title')" :breadcrumbs="[
        ['label' => __('admin/users.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/users.forms.breadcrumbs.users'), 'url' => route('admin.users.index')],
        ['label' => __('admin/users.forms.breadcrumbs.create')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/users.forms.create.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/users.forms.create.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/users.forms.create.card_title') }}</x-slot>

        <form id="user-create-form" action="{{ route('admin.users.store') }}" method="POST"
            class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/users.fields.first_name')" required :error="$errors->first('first_name')">
                    <x-input type="text" name="first_name" id="first_name" :placeholder="__('admin/users.forms.placeholders.first_name')"
                        value="{{ old('first_name') }}" required class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/users.fields.last_name')" required :error="$errors->first('last_name')">
                    <x-input type="text" name="last_name" id="last_name" :placeholder="__('admin/users.forms.placeholders.last_name')"
                        value="{{ old('last_name') }}" required class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/users.fields.email')" required :error="$errors->first('email')">
                <x-input type="email" name="email" id="email" :placeholder="__('admin/users.forms.placeholders.email')"
                    value="{{ old('email') }}" required class="w-full" />
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/users.fields.country_code')" :error="$errors->first('country_code')">
                    <x-input type="text" name="country_code" id="country_code" :placeholder="__('admin/users.forms.placeholders.country_code')"
                        value="{{ old('country_code') }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/users.fields.phone_number')" :error="$errors->first('phone_number')">
                    <x-input type="text" name="phone_number" id="phone_number" :placeholder="__('admin/users.forms.placeholders.phone_number')"
                        value="{{ old('phone_number') }}" class="w-full" />
                </x-form-group>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/users.fields.password')" required :error="$errors->first('password')">
                    <x-input type="password" name="password" id="password" :placeholder="__('admin/users.forms.placeholders.password')"
                        required class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/users.fields.password_confirmation')" required :error="$errors->first('password_confirmation')">
                    <x-input type="password" name="password_confirmation" id="password_confirmation" :placeholder="__('admin/users.forms.placeholders.password_confirmation')"
                        required class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/users.fields.is_active')">
                <x-toggle name="is_active" id="is_active" :checked="old('is_active', true)"
                    :label="__('admin/users.forms.labels.active_user')" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/users.forms.create.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.admin>
