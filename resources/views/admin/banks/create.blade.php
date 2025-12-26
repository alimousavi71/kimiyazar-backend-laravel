<x-layouts.admin :title="__('admin/banks.create_title')" :header-title="__('admin/banks.create_title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.banks.index')],
    ['label' => __('admin/banks.create_title')]
]">
    <x-card>
        <form action="{{ route('admin.banks.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-input
                name="name"
                :label="__('admin/banks.fields.name')"
                required
                :error="$errors->first('name')"
                placeholder="e.g., Melli Bank, Pasargad Bank"
            />

            <x-input
                name="logo"
                :label="__('admin/banks.fields.logo')"
                :error="$errors->first('logo')"
                placeholder="Bank logo path or URL"
            />

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.save') }}
                </button>
                <a href="{{ route('admin.banks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.cancel') }}
                </a>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
