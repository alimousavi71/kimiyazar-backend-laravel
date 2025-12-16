<x-layouts.admin :title="__('admin/contents.forms.edit.title')"
    :header-title="__('admin/contents.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('admin/contents.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/contents.forms.breadcrumbs.contents'), 'url' => route('admin.contents.index')],
        ['label' => __('admin/contents.forms.breadcrumbs.edit')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/contents.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/contents.forms.edit.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/contents.forms.edit.card_title') }}</x-slot>

        <form id="content-edit-form" action="{{ route('admin.contents.update', $content->id) }}" method="POST"
            class="space-y-6">
            @csrf
            @method('PUT')

            <x-form-group :label="__('admin/contents.fields.type')" required :error="$errors->first('type')">
                <x-select name="type" id="type" class="w-full" required>
                    <option value="">{{ __('admin/contents.forms.placeholders.select_type') }}</option>
                    @foreach(\App\Enums\Database\ContentType::cases() as $type)
                        <option value="{{ $type->value }}" {{ old('type', $content->type->value) === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </x-select>
            </x-form-group>

            <x-form-group :label="__('admin/contents.fields.title')" required :error="$errors->first('title')">
                <x-input type="text" name="title" id="title"
                    :placeholder="__('admin/contents.forms.placeholders.title')"
                    value="{{ old('title', $content->title) }}" required class="w-full" />
            </x-form-group>

            <x-form-group :label="__('admin/contents.fields.body')" :error="$errors->first('body')">
                <x-textarea name="body" id="body" rows="10" :placeholder="__('admin/contents.forms.placeholders.body')"
                    class="w-full">{{ old('body', $content->body) }}</x-textarea>
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/contents.fields.seo_description')"
                    :error="$errors->first('seo_description')">
                    <x-input type="text" name="seo_description" id="seo_description"
                        :placeholder="__('admin/contents.forms.placeholders.seo_description')"
                        value="{{ old('seo_description', $content->seo_description) }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/contents.fields.seo_keywords')" :error="$errors->first('seo_keywords')">
                    <x-input type="text" name="seo_keywords" id="seo_keywords"
                        :placeholder="__('admin/contents.forms.placeholders.seo_keywords')"
                        value="{{ old('seo_keywords', $content->seo_keywords) }}" class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/contents.fields.is_active')">
                <x-toggle name="is_active" id="is_active" :checked="old('is_active', $content->is_active)"
                    :label="__('admin/contents.forms.labels.active_content')" />
            </x-form-group>

            <x-form-group :label="__('admin/photos.title')" :error="$errors->first('photos')">
                <x-photo-manager photoable-type="{{ \App\Models\Content::class }}" :photoable-id="$content->id"
                    :limit="10" label="{{ __('admin/photos.title') }}" />
            </x-form-group>

            <x-form-group :label="__('admin/tags.title')" :error="$errors->first('tags')">
                <x-tag-manager tagable-type="{{ \App\Models\Content::class }}" :tagable-id="$content->id"
                    label="{{ __('admin/tags.title') }}" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.contents.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/contents.forms.edit.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite(['resources/js/admin-form-validation.js', 'resources/js/form-with-tags.js'])
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                initFormWithTags({
                    formId: 'content-edit-form',
                    tagManagerSelector: '[id^="tag-manager-"]',
                    tagableType: '{{ \App\Models\Content::class }}',
                    tagableId: {{ $content->id }},
                    redirectUrl: '{{ route('admin.contents.index') }}',
                    successMessage: '{{ __('admin/contents.messages.updated') }}',
                    errorMessage: '{{ __('admin/contents.messages.update_failed') }}',
                });
            });
        </script>
    @endpush
</x-layouts.admin>