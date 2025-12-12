<x-layouts.admin :title="__('admin/admins.forms.create.title')"
    :header-title="__('admin/admins.forms.create.header_title')" :breadcrumbs="[
        ['label' => __('admin/admins.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/admins.forms.breadcrumbs.admins'), 'url' => route('admin.admins.index')],
        ['label' => __('admin/admins.forms.breadcrumbs.create')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/admins.forms.create.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/admins.forms.create.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/admins.forms.create.card_title') }}</x-slot>

        <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/admins.fields.first_name')" required
                    :error="$errors->first('first_name')">
                    <x-input type="text" name="first_name" id="first_name"
                        :placeholder="__('admin/admins.forms.placeholders.first_name')" value="{{ old('first_name') }}"
                        required class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/admins.fields.last_name')" required
                    :error="$errors->first('last_name')">
                    <x-input type="text" name="last_name" id="last_name"
                        :placeholder="__('admin/admins.forms.placeholders.last_name')" value="{{ old('last_name') }}"
                        required class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/admins.fields.email')" required :error="$errors->first('email')">
                <x-input type="email" name="email" id="email" :placeholder="__('admin/admins.forms.placeholders.email')"
                    value="{{ old('email') }}" required class="w-full" />
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/admins.fields.password')" required :error="$errors->first('password')">
                    <x-input type="password" name="password" id="password"
                        :placeholder="__('admin/admins.forms.placeholders.password')" required class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/admins.fields.password_confirmation')" required>
                    <x-input type="password" name="password_confirmation" id="password_confirmation"
                        :placeholder="__('admin/admins.forms.placeholders.password_confirmation')" required
                        class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/admins.fields.is_block')">
                <x-toggle name="is_block" id="is_block" :checked="old('is_block', false)"
                    :label="__('admin/admins.forms.labels.block_admin')" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.admins.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/admins.forms.create.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>