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

            <x-form-group :label="__('admin/menus.fields.name')" required :error="$errors->first('name')">
                <x-input type="text" name="name" id="name" :placeholder="__('admin/menus.forms.placeholders.name')"
                    value="{{ old('name') }}" required class="w-full" />
            </x-form-group>

            <!-- Links will be managed after creation in edit page -->

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