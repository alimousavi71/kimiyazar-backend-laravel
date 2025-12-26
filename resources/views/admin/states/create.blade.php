<x-layouts.admin :title="__('admin/states.create_title')" :header-title="__('admin/states.create_title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.states.index')],
    ['label' => __('admin/states.create_title')]
]">
    <x-card>
        <form action="{{ route('admin.states.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-select
                name="country_id"
                :label="__('admin/states.fields.country_id')"
                :options="$countries->pluck('name', 'id')->toArray()"
                required
                :error="$errors->first('country_id')"
            />

            <x-input
                name="name"
                :label="__('admin/states.fields.name')"
                required
                :error="$errors->first('name')"
                placeholder="e.g., Tehran, California"
            />

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.save') }}
                </button>
                <a href="{{ route('admin.states.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.cancel') }}
                </a>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
