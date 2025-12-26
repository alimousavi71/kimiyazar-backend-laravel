<x-layouts.admin :title="__('admin/countries.edit_title')" :header-title="__('admin/countries.edit_title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.countries.index')],
    ['label' => __('admin/countries.edit_title')]
]">
    <x-card>
        <form action="{{ route('admin.countries.update', $country->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <x-form.input
                name="name"
                :label="__('admin/countries.fields.name')"
                :value="$country->name"
                required
                :error="$errors->first('name')"
            />

            <x-form.input
                name="code"
                :label="__('admin/countries.fields.code')"
                :value="$country->code"
                :error="$errors->first('code')"
            />

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.save') }}
                </button>
                <a href="{{ route('admin.countries.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.cancel') }}
                </a>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
