<x-layouts.admin :title="__('admin/banners.show.title')" :header-title="__('admin/banners.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/banners.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/banners.forms.breadcrumbs.banners'), 'url' => route('admin.banners.index')],
        ['label' => __('admin/banners.show.title')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/banners.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/banners.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.banners.edit', $banner->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/banners.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.banners.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/banners.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/banners.show.banner_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $banner->name }}</p>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.position') }}</label>
                        <div class="mt-1">
                            <x-badge variant="info" size="md">{{ $banner->position->value }}</x-badge>
                            @php
                                $dimensions = config('banner.positions.' . $banner->position->value, ['width' => 1200, 'height' => 300]);
                            @endphp
                            <span
                                class="text-sm text-gray-500 ms-2">({{ $dimensions['width'] }}x{{ $dimensions['height'] }})</span>
                        </div>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.banner_file') }}</label>
                        <div class="mt-1">
                            @if($banner->banner_file)
                                <img src="{{ asset('storage/' . $banner->banner_file) }}" alt="{{ $banner->name }}"
                                    class="w-full max-w-md h-auto object-cover rounded-lg border border-gray-200">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.link') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($banner->link)
                                <a href="{{ $banner->link }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                                    {{ $banner->link }}
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.target_type') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $banner->target_type ?: '-' }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.target_id') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $banner->target_id ?: '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.is_active') }}</label>
                        <div class="mt-1">
                            @if($banner->is_active)
                                <x-badge variant="success" size="md">{{ __('admin/banners.status.active') }}</x-badge>
                            @else
                                <x-badge variant="danger" size="md">{{ __('admin/banners.status.inactive') }}</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot name="title">{{ __('admin/banners.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.created_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $banner->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/banners.fields.updated_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $banner->updated_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/banners.show.quick_actions') }}</x-slot>

                <div class="space-y-3">
                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="block">
                        <x-button variant="primary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.edit') }}
                        </x-button>
                    </a>
                    <a href="{{ route('admin.banners.index') }}" class="block">
                        <x-button variant="secondary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.back') }}
                        </x-button>
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>