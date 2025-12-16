<x-layouts.admin :title="__('admin/faqs.forms.edit.title')"
    :header-title="__('admin/faqs.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('admin/faqs.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/faqs.forms.breadcrumbs.faqs'), 'url' => route('admin.faqs.index')],
        ['label' => __('admin/faqs.forms.breadcrumbs.edit')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/faqs.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/faqs.forms.edit.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/faqs.forms.edit.card_title') }}</x-slot>

        <form id="faq-edit-form" action="{{ route('admin.faqs.update', $faq->id) }}" method="POST"
            class="space-y-6">
            @csrf
            @method('PUT')

            <x-form-group :label="__('admin/faqs.fields.question')" required :error="$errors->first('question')">
                <x-input type="text" name="question" id="question" :placeholder="__('admin/faqs.forms.placeholders.question')"
                    value="{{ old('question', $faq->question) }}" required class="w-full" />
            </x-form-group>

            <x-form-group :label="__('admin/faqs.fields.answer')" required :error="$errors->first('answer')">
                <x-textarea name="answer" id="answer" :placeholder="__('admin/faqs.forms.placeholders.answer')"
                    rows="6" required class="w-full">{{ old('answer', $faq->answer) }}</x-textarea>
            </x-form-group>

            <x-form-group :label="__('admin/faqs.fields.is_published')">
                <x-toggle name="is_published" id="is_published" :checked="old('is_published', $faq->is_published)"
                    :label="__('admin/faqs.forms.labels.publish_question')" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.faqs.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/faqs.forms.edit.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.admin>
