<x-layouts.admin :title="__('admin/categories.forms.create.title')"
    :header-title="__('admin/categories.forms.create.header_title')" :breadcrumbs="[
        ['label' => __('admin/categories.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/categories.forms.breadcrumbs.categories'), 'url' => route('admin.categories.index')],
        ['label' => __('admin/categories.forms.breadcrumbs.create')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/categories.forms.create.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/categories.forms.create.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/categories.forms.create.card_title') }}</x-slot>

        <form id="category-create-form" action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-form-group :label="__('admin/categories.fields.name')" required :error="$errors->first('name')">
                <x-input type="text" name="name" id="name" :placeholder="__('admin/categories.forms.placeholders.name')"
                    value="{{ old('name') }}" required class="w-full" />
            </x-form-group>

            <x-form-group :label="__('admin/categories.fields.parent')" :error="$errors->first('parent_id')">
                <x-select name="parent_id" id="parent_id" class="w-full">
                    <option value="0">{{ __('admin/categories.forms.placeholders.no_parent') }}</option>
                    @foreach($rootCategories as $rootCategory)
                        <option value="{{ $rootCategory->id }}" {{ old('parent_id') == $rootCategory->id ? 'selected' : '' }}>
                            {{ $rootCategory->name }}
                        </option>
                    @endforeach
                </x-select>
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/categories.fields.sort_order')" :error="$errors->first('sort_order')">
                    <x-input type="number" name="sort_order" id="sort_order"
                        :placeholder="__('admin/categories.forms.placeholders.sort_order')"
                        value="{{ old('sort_order', 0) }}" min="0" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/categories.fields.is_active')">
                    <x-toggle name="is_active" id="is_active" :checked="old('is_active', true)"
                        :label="__('admin/categories.forms.labels.active_category')" />
                </x-form-group>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/categories.forms.create.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.admin>