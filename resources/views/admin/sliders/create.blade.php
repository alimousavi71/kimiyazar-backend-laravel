<x-layouts.admin :title="__('admin/sliders.forms.create.title')"
    :header-title="__('admin/sliders.forms.create.header_title')" :breadcrumbs="[
        ['label' => __('admin/sliders.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/sliders.forms.breadcrumbs.sliders'), 'url' => route('admin.sliders.index')],
        ['label' => __('admin/sliders.forms.breadcrumbs.create')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/sliders.forms.create.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/sliders.forms.create.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/sliders.forms.create.card_title') }}</x-slot>

        <form id="slider-create-form" action="{{ route('admin.sliders.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-form-group :label="__('admin/sliders.fields.title')" required :error="$errors->first('title')">
                <x-input type="text" name="title" id="title" :placeholder="__('admin/sliders.forms.placeholders.title')"
                    value="{{ old('title') }}" required class="w-full" />
            </x-form-group>

            <x-form-group :label="__('admin/sliders.fields.heading')" :error="$errors->first('heading')">
                <x-input type="text" name="heading" id="heading"
                    :placeholder="__('admin/sliders.forms.placeholders.heading')" value="{{ old('heading') }}"
                    class="w-full" />
            </x-form-group>

            <x-form-group :label="__('admin/sliders.fields.description')" :error="$errors->first('description')">
                <x-textarea name="description" id="description" rows="5"
                    :placeholder="__('admin/sliders.forms.placeholders.description')"
                    class="w-full">{{ old('description') }}</x-textarea>
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/sliders.fields.sort_order')" :error="$errors->first('sort_order')">
                    <x-input type="number" name="sort_order" id="sort_order"
                        :placeholder="__('admin/sliders.forms.placeholders.sort_order')"
                        value="{{ old('sort_order') }}" min="0" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/sliders.fields.is_active')">
                    <x-toggle name="is_active" id="is_active" :checked="old('is_active', true)"
                        :label="__('admin/sliders.forms.labels.active_slider')" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/photos.title')" :error="$errors->first('photos')">
                <x-photo-manager photoable-type="{{ \App\Models\Slider::class }}" :photoable-id="null" :limit="1"
                    label="{{ __('admin/photos.title') }}" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.sliders.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/sliders.forms.create.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite(['resources/js/admin-form-validation.js', 'resources/js/form-with-photos.js'])
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initFormWithPhotos({
                    formId: 'slider-create-form',
                    photoManagerSelector: '[id^="photo-manager-"]',
                    photoableType: '{{ \App\Models\Slider::class }}',
                    redirectUrl: '{{ route('admin.sliders.index') }}',
                    successMessage: '{{ __('admin/sliders.messages.created') }}',
                    errorMessage: '{{ __('admin/sliders.messages.create_failed') }}',
                });
            });
        </script>
    @endpush
</x-layouts.admin>

