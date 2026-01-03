<x-layouts.admin :title="__('admin/sliders.show.title')" :header-title="__('admin/sliders.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/sliders.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/sliders.forms.breadcrumbs.sliders'), 'url' => route('admin.sliders.index')],
        ['label' => __('admin/sliders.show.title')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/sliders.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/sliders.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.sliders.edit', $slider->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/sliders.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.sliders.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/sliders.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/sliders.show.slider_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/sliders.fields.title') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $slider->title }}</p>
                    </div>

                    @if($slider->heading)
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('admin/sliders.fields.heading') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $slider->heading }}</p>
                        </div>
                    @endif

                    @if($slider->description)
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('admin/sliders.fields.description') }}</label>
                            <div class="text-base text-gray-900 mt-1 prose max-w-none">
                                {!! nl2br(e($slider->description)) !!}
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/photos.title') }}</label>
                        <div class="mt-1">
                            <x-photo-manager photoable-type="{{ \App\Models\Slider::class }}"
                                :photoable-id="$slider->id" :read-only="true" label="" />
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        
        <div class="space-y-6">
            
            <x-card>
                <x-slot name="title">{{ __('admin/sliders.show.status') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/sliders.fields.is_active') }}</label>
                        <div class="mt-1">
                            @if($slider->is_active)
                                <x-badge variant="success" size="md">{{ __('admin/sliders.status.active') }}</x-badge>
                            @else
                                <x-badge variant="danger" size="md">{{ __('admin/sliders.status.inactive') }}</x-badge>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/sliders.fields.sort_order') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $slider->sort_order }}</p>
                    </div>
                </div>
            </x-card>

            
            <x-card>
                <x-slot name="title">{{ __('admin/sliders.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/sliders.fields.created_at') }}</label>
                        <p class="text-base text-gray-900 mt-1"><x-date :date="$slider->created_at" type="datetime-full" /></p>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/sliders.fields.updated_at') }}</label>
                        <p class="text-base text-gray-900 mt-1"><x-date :date="$slider->updated_at" type="datetime-full" /></p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

</x-layouts.admin>

