<x-layouts.admin :title="__('admin/categories.show.title')" :header-title="__('admin/categories.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/categories.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/categories.forms.breadcrumbs.categories'), 'url' => route('admin.categories.index')],
        ['label' => __('admin/categories.forms.breadcrumbs.details')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/categories.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/categories.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.categories.edit', $category->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/categories.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.categories.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/categories.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/categories.show.basic_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/categories.fields.name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $category->name }}</p>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/categories.fields.slug') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $category->slug }}</p>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/categories.fields.parent') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($category->parent)
                                <span class="text-gray-700">{{ $category->parent->name }}</span>
                            @else
                                <span class="text-gray-400">{{ __('admin/categories.status.root') }}</span>
                            @endif
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/categories.fields.is_active') }}</label>
                            <div class="mt-1">
                                @if($category->is_active)
                                    <x-badge variant="success"
                                        size="md">{{ __('admin/categories.status.active') }}</x-badge>
                                @else
                                    <x-badge variant="danger"
                                        size="md">{{ __('admin/categories.status.inactive') }}</x-badge>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/categories.fields.sort_order') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $category->sort_order }}</p>
                        </div>
                    </div>
                </div>
            </x-card>

            @if($category->children->count() > 0)
                <x-card>
                    <x-slot name="title">{{ __('admin/categories.show.children_title') }}</x-slot>

                    <div class="space-y-2">
                        @foreach($category->children as $child)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="font-medium text-gray-900">{{ $child->name }}</span>
                                    @if($child->is_active)
                                        <x-badge variant="success" size="sm">{{ __('admin/categories.status.active') }}</x-badge>
                                    @else
                                        <x-badge variant="danger" size="sm">{{ __('admin/categories.status.inactive') }}</x-badge>
                                    @endif
                                </div>
                                <a href="{{ route('admin.categories.show', $child->id) }}"
                                    class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    {{ __('admin/components.buttons.view') }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endif

            <x-card>
                <x-slot name="title">{{ __('admin/categories.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/categories.fields.created_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $category->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/categories.fields.updated_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $category->updated_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/categories.show.quick_actions') }}</x-slot>

                <div class="space-y-3">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="block">
                        <x-button variant="primary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.edit') }}
                        </x-button>
                    </a>
                    <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" class="block">
                        <x-button variant="secondary" size="sm" class="w-full">
                            {{ __('admin/categories.show.buttons.add_child') }}
                        </x-button>
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>