<x-layouts.admin :title="__('admin/users.forms.edit.title')"
    :header-title="__('admin/users.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('admin/users.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/users.forms.breadcrumbs.users'), 'url' => route('admin.users.index')],
        ['label' => __('admin/users.forms.breadcrumbs.edit')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/users.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/users.forms.edit.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/users.forms.edit.card_title') }}</x-slot>

        <form id="user-edit-form" action="{{ route('admin.users.update', $user->id) }}" method="POST"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/users.fields.first_name')" required :error="$errors->first('first_name')">
                    <x-input type="text" name="first_name" id="first_name" :placeholder="__('admin/users.forms.placeholders.first_name')"
                        value="{{ old('first_name', $user->first_name) }}" required class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/users.fields.last_name')" required :error="$errors->first('last_name')">
                    <x-input type="text" name="last_name" id="last_name" :placeholder="__('admin/users.forms.placeholders.last_name')"
                        value="{{ old('last_name', $user->last_name) }}" required class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/users.fields.email')" required :error="$errors->first('email')">
                <x-input type="email" name="email" id="email" :placeholder="__('admin/users.forms.placeholders.email')"
                    value="{{ old('email', $user->email) }}" required class="w-full" />
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/users.fields.country_code')" :error="$errors->first('country_code')">
                    <x-input type="text" name="country_code" id="country_code" :placeholder="__('admin/users.forms.placeholders.country_code')"
                        value="{{ old('country_code', $user->country_code) }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/users.fields.phone_number')" :error="$errors->first('phone_number')">
                    <x-input type="text" name="phone_number" id="phone_number" :placeholder="__('admin/users.forms.placeholders.phone_number')"
                        value="{{ old('phone_number', $user->phone_number) }}" class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/users.fields.is_active')">
                <x-toggle name="is_active" id="is_active" :checked="old('is_active', $user->is_active)"
                    :label="__('admin/users.forms.labels.active_user')" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/users.forms.edit.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.admin>
