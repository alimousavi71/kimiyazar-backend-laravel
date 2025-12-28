<x-layouts.admin :title="__('admin/menus.show.title')" :header-title="__('admin/menus.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/menus.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/menus.forms.breadcrumbs.menus'), 'url' => route('admin.menus.index')],
        ['label' => __('admin/menus.forms.breadcrumbs.details')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/menus.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/menus.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.menus.edit', $menu->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/components.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.menus.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/components.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/menus.show.menu_info') }}</x-slot>

                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('admin/menus.fields.name') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $menu->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('admin/menus.fields.created_at') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $menu->created_at->format('Y-m-d H:i:s') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('admin/menus.fields.updated_at') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $menu->updated_at->format('Y-m-d H:i:s') }}</dd>
                    </div>
                </dl>
            </x-card>

            
            <x-card>
                <x-slot name="title">{{ __('admin/menus.show.links') }} ({{ count($menu->getOrderedLinks()) }})</x-slot>

                @if(count($menu->getOrderedLinks()) > 0)
                    <div class="space-y-3">
                        @foreach($menu->getOrderedLinks() as $link)
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="font-medium text-gray-900">{{ $link['title'] ?? '-' }}</div>
                                <div class="text-sm text-gray-500 mt-1">{{ $link['url'] ?? '#' }}</div>
                                <div class="text-xs text-gray-400 mt-2">
                                    <span>{{ $link['type'] === 'content' ? __('admin/menus.link_types.content') : __('admin/menus.link_types.custom') }}</span>
                                    @if(isset($link['order']))
                                        <span> • {{ __('admin/menus.fields.order') }}: {{ $link['order'] }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        {{ __('admin/menus.messages.no_links') }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>

</x-layouts.admin>