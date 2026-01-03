<x-layouts.admin :title="__('admin/faqs.show.title')" :header-title="__('admin/faqs.show.header_title')" :breadcrumbs="[
        ['label' => __('admin/faqs.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/faqs.forms.breadcrumbs.faqs'), 'url' => route('admin.faqs.index')],
        ['label' => __('admin/faqs.show.title')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/faqs.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/faqs.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.faqs.edit', $faq->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/faqs.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.faqs.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/faqs.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/faqs.show.question_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/faqs.fields.question') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $faq->question }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/faqs.fields.answer') }}</label>
                        <div class="text-base text-gray-900 mt-1 bg-gray-50 p-4 rounded-lg whitespace-pre-wrap">
                            {{ $faq->answer }}
                        </div>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/faqs.fields.is_published') }}</label>
                        <div class="mt-1">
                            @if($faq->is_published)
                                <x-badge variant="success" size="md">{{ __('admin/faqs.status.published') }}</x-badge>
                            @else
                                <x-badge variant="warning" size="md">{{ __('admin/faqs.status.unpublished') }}</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot name="title">{{ __('admin/faqs.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/faqs.fields.created_at') }}</label>
                            <p class="text-base text-gray-900 mt-1"><x-date :date="$faq->created_at"
                                    type="datetime-full" /></p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/faqs.fields.updated_at') }}</label>
                            <p class="text-base text-gray-900 mt-1"><x-date :date="$faq->updated_at"
                                    type="datetime-full" /></p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>


        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/faqs.show.quick_actions') }}</x-slot>

                <div class="space-y-3">
                    <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="block">
                        <x-button variant="primary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.edit') }}
                        </x-button>
                    </a>
                    <a href="{{ route('admin.faqs.index') }}" class="block">
                        <x-button variant="secondary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.back') }}
                        </x-button>
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>