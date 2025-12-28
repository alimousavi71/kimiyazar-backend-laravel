<x-layouts.admin :title="__('admin/contents.forms.create.title')"
    :header-title="__('admin/contents.forms.create.header_title')" :breadcrumbs="[
        ['label' => __('admin/contents.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/contents.forms.breadcrumbs.contents'), 'url' => route('admin.contents.index')],
        ['label' => __('admin/contents.forms.breadcrumbs.create')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/contents.forms.create.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/contents.forms.create.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/contents.forms.create.card_title') }}</x-slot>

        <form id="content-create-form" action="{{ route('admin.contents.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-form-group :label="__('admin/contents.fields.type')" required :error="$errors->first('type')">
                <x-select name="type" id="type" class="w-full" required>
                    <option value="">{{ __('admin/contents.forms.placeholders.select_type') }}</option>
                    @foreach(\App\Enums\Database\ContentType::cases() as $type)
                        <option value="{{ $type->value }}" {{ old('type') === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </x-select>
            </x-form-group>

            <x-form-group :label="__('admin/contents.fields.title')" required :error="$errors->first('title')">
                <x-input type="text" name="title" id="title"
                    :placeholder="__('admin/contents.forms.placeholders.title')" value="{{ old('title') }}" required
                    class="w-full" />
            </x-form-group>

            <x-form-group :label="__('admin/contents.fields.body')" :error="$errors->first('body')">
                <x-textarea name="body" id="body" rows="10" :placeholder="__('admin/contents.forms.placeholders.body')"
                    class="w-full">{{ old('body') }}</x-textarea>
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/contents.fields.seo_description')"
                    :error="$errors->first('seo_description')">
                    <x-input type="text" name="seo_description" id="seo_description"
                        :placeholder="__('admin/contents.forms.placeholders.seo_description')"
                        value="{{ old('seo_description') }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/contents.fields.seo_keywords')" :error="$errors->first('seo_keywords')">
                    <x-input type="text" name="seo_keywords" id="seo_keywords"
                        :placeholder="__('admin/contents.forms.placeholders.seo_keywords')"
                        value="{{ old('seo_keywords') }}" class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/contents.fields.is_active')">
                <x-toggle name="is_active" id="is_active" :checked="old('is_active', false)"
                    :label="__('admin/contents.forms.labels.active_content')" />
            </x-form-group>

            <x-form-group :label="__('admin/photos.title')" :error="$errors->first('photos')">
                <x-photo-manager photoable-type="{{ \App\Models\Content::class }}" :photoable-id="null" :limit="10"
                    label="{{ __('admin/photos.title') }}" />
            </x-form-group>

            <x-form-group :label="__('admin/tags.title')" :error="$errors->first('tags')">
                <x-tag-manager tagable-type="{{ \App\Models\Content::class }}" :tagable-id="null" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.contents.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/contents.forms.create.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite(['resources/js/admin-form-validation.js', 'resources/js/form-with-photos.js', 'resources/js/form-with-tags.js'])
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                initFormWithPhotos({
                    formId: 'content-create-form',
                    photoManagerSelector: '[id^="photo-manager-"]',
                    photoableType: '{{ \App\Models\Content::class }}',
                    redirectUrl: '{{ route('admin.contents.index') }}',
                    successMessage: '{{ __('admin/contents.messages.created') }}'
                });

                initFormWithTags({
                    formId: 'content-create-form',
                    tagManagerSelector: '[id^="tag-manager-"]',
                    tagableType: '{{ \App\Models\Content::class }}',
                    tagableId: null,
                    redirectUrl: '{{ route('admin.contents.index') }}',
                    successMessage: '{{ __('admin/contents.messages.created') }}',
                    errorMessage: '{{ __('admin/contents.messages.create_failed') }}',
                });
            });
        </script>
    @endpush
</x-layouts.admin>