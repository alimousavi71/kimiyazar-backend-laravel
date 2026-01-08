<x-layouts.admin :title="__('admin/modals.forms.create.title')"
    :header-title="__('admin/modals.forms.create.header_title')" :breadcrumbs="[
        ['label' => __('admin/modals.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/modals.forms.breadcrumbs.modals'), 'url' => route('admin.modals.index')],
        ['label' => __('admin/modals.forms.breadcrumbs.create')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/modals.forms.create.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/modals.forms.create.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/modals.forms.create.card_title') }}</x-slot>

        <form id="modal-create-form" action="{{ route('admin.modals.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-form-group :label="__('admin/modals.fields.title')" required :error="$errors->first('title')">
                <x-input type="text" name="title" id="title" :placeholder="__('admin/modals.forms.placeholders.title')"
                    value="{{ old('title') }}" required class="w-full" />
            </x-form-group>

            <x-form-group :label="__('admin/modals.fields.content')" required :error="$errors->first('content')">
                <x-textarea name="content" id="content" rows="6"
                    :placeholder="__('admin/modals.forms.placeholders.content')"
                    class="w-full">{{ old('content') }}</x-textarea>
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/modals.fields.button_text')" :error="$errors->first('button_text')">
                    <x-input type="text" name="button_text" id="button_text"
                        :placeholder="__('admin/modals.forms.placeholders.button_text')"
                        value="{{ old('button_text') }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/modals.fields.button_url')" :error="$errors->first('button_url')">
                    <x-input type="url" name="button_url" id="button_url"
                        :placeholder="__('admin/modals.forms.placeholders.button_url')" value="{{ old('button_url') }}"
                        class="w-full" />
                </x-form-group>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/modals.fields.close_text')" :error="$errors->first('close_text')">
                    <x-input type="text" name="close_text" id="close_text"
                        :placeholder="__('admin/modals.forms.placeholders.close_text')"
                        value="{{ old('close_text', 'بستن') }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/modals.fields.priority')" :error="$errors->first('priority')">
                    <x-input type="number" name="priority" id="priority"
                        :placeholder="__('admin/modals.forms.placeholders.priority')" value="{{ old('priority', 0) }}"
                        min="0" max="999" class="w-full" />
                </x-form-group>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-form-group :label="__('admin/modals.fields.start_at')" :error="$errors->first('start_at')">
                    <x-input type="text" name="start_at" id="start_at" data-jdp value="{{ old('start_at') }}"
                        class="w-full" placeholder="YYYY/MM/DD" />
                </x-form-group>

                <x-form-group :label="__('admin/modals.fields.end_at')" :error="$errors->first('end_at')">
                    <x-input type="text" name="end_at" id="end_at" data-jdp value="{{ old('end_at') }}"
                        class="w-full" placeholder="YYYY/MM/DD" />
                </x-form-group>

                <x-form-group>
                    <x-toggle name="is_published" id="is_published" :checked="old('is_published', false)"
                        :label="__('admin/modals.forms.labels.active_modal')" />
                </x-form-group>
            </div>

            <x-form-group>
                <x-toggle name="is_rememberable" id="is_rememberable" :checked="old('is_rememberable', true)"
                    :label="__('admin/modals.forms.labels.show_remember_option')" />
                <p class="text-xs text-gray-500 mt-2">{{ __('admin/modals.forms.hints.remember') }}</p>
            </x-form-group>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-medium text-gray-900 mb-4">{{ __('admin/modals.forms.sections.polymorphic') }}
                </h3>

                <x-morphable-selector type-field-name="modalable_type" id-field-name="modalable_id"
                    :selected-type="old('modalable_type')" :selected-id="old('modalable_id')"
                    :type-error="$errors->first('modalable_type')" :id-error="$errors->first('modalable_id')" />

                <p class="text-xs text-gray-500 mt-2">{{ __('admin/modals.forms.hints.modalable_type') }}</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.modals.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/modals.forms.create.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @vite(['resources/js/modal-date-picker.js'])

</x-layouts.admin>