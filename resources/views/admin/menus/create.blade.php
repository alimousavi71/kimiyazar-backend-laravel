<x-layouts.admin :title="__('admin/menus.forms.create.title')"
    :header-title="__('admin/menus.forms.create.header_title')" :breadcrumbs="[
        ['label' => __('admin/menus.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/menus.forms.breadcrumbs.menus'), 'url' => route('admin.menus.index')],
        ['label' => __('admin/menus.forms.breadcrumbs.create')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/menus.forms.create.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/menus.forms.create.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/menus.forms.create.card_title') }}</x-slot>

        <form id="menu-create-form" action="{{ route('admin.menus.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-input
                name="name"
                :label="__('admin/menus.fields.name')"
                :placeholder="__('admin/menus.forms.placeholders.name')"
                :value="old('name')"
                required
                :error="$errors->first('name')"
                class="w-full"
            />

            <x-select
                name="type"
                :label="__('admin/menus.fields.type')"
                required
                :error="$errors->first('type')"
                class="w-full"
            >
                <option value="">{{ __('admin/components.form.select_option') }}</option>
                <option value="quick_access" @selected(old('type') === 'quick_access')>
                    {{ __('admin/menus.types.quick_access') }}
                </option>
                <option value="services" @selected(old('type') === 'services')>
                    {{ __('admin/menus.types.services') }}
                </option>
                <option value="custom" @selected(old('type') === 'custom')>
                    {{ __('admin/menus.types.custom') }}
                </option>
            </x-select>

            

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.menus.index') }}">
                    <x-button variant="secondary" size="md" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" size="md" type="submit">
                    {{ __('admin/components.buttons.create') }}
                </x-button>
            </div>
        </form>
    </x-card>

</x-layouts.admin>