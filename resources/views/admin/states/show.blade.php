<x-layouts.admin :title="__('admin/states.show_title')" :header-title="__('admin/states.show_title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.states.index')],
    ['label' => __('admin/states.show_title')]
]">
    <x-card>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">{{ __('admin/states.sections.state_info') }}</h3>
                <a href="{{ route('admin.states.edit', $state->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm">
                    {{ __('admin/components.buttons.edit') }}
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/states.fields.id') }}</p>
                    <p class="text-lg font-semibold">{{ $state->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/states.fields.name') }}</p>
                    <p class="text-lg font-semibold">{{ $state->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/states.fields.country_id') }}</p>
                    <p class="text-lg font-semibold">{{ $state->country->name ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="flex gap-3 pt-6 border-t">
                <a href="{{ route('admin.states.edit', $state->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.edit') }}
                </a>
                <a href="{{ route('admin.states.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.back') }}
                </a>
            </div>
        </div>
    </x-card>
</x-layouts.admin>
