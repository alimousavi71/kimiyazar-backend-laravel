<x-layouts.admin :title="__('admin/contents.show.title')" :header-title="__('admin/contents.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/contents.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/contents.forms.breadcrumbs.contents'), 'url' => route('admin.contents.index')],
        ['label' => __('admin/contents.show.title')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/contents.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/contents.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.contents.edit', $content->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/contents.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.contents.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/contents.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/contents.show.content_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.type') }}</label>
                        <div class="mt-1">
                            <x-badge variant="info" size="md">{{ $content->type->label() }}</x-badge>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.title') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $content->title }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.slug') }}</label>
                        <p class="text-base text-gray-900 mt-1 font-mono text-sm">{{ $content->slug }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.body') }}</label>
                        <div class="text-base text-gray-900 mt-1 prose max-w-none">
                            {!! nl2br(e($content->body)) !!}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.seo_description') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                {{ $content->seo_description ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.seo_keywords') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                {{ $content->seo_keywords ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/photos.title') }}</label>
                        <div class="mt-1">
                            <x-photo-manager 
                                photoable-type="{{ \App\Models\Content::class }}"
                                :photoable-id="$content->id"
                                :read-only="true"
                                label="" />
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <x-card>
                <x-slot name="title">{{ __('admin/contents.show.status') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.is_active') }}</label>
                        <div class="mt-1">
                            @if($content->is_active)
                                <x-badge variant="success" size="md">{{ __('admin/contents.status.active') }}</x-badge>
                            @else
                                <x-badge variant="danger" size="md">{{ __('admin/contents.status.inactive') }}</x-badge>
                            @endif
                        </div>
                    </div>

                    @if($content->type === \App\Enums\Database\ContentType::PAGE)
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.is_undeletable') }}</label>
                            <div class="mt-1">
                                @if($content->is_undeletable)
                                    <x-badge variant="warning" size="md">{{ __('admin/components.status.yes') }}</x-badge>
                                @else
                                    <x-badge variant="secondary" size="md">{{ __('admin/components.status.no') }}</x-badge>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.visit_count') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ number_format($content->visit_count) }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Timestamps Card -->
            <x-card>
                <x-slot name="title">{{ __('admin/contents.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.created_at') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $content->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/contents.fields.updated_at') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $content->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

</x-layouts.admin>