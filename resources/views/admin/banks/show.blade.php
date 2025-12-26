<x-layouts.admin :title="__('admin/banks.show_title')" :header-title="__('admin/banks.show_title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.banks.index')],
    ['label' => __('admin/banks.show_title')]
]">
    <x-card>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">{{ __('admin/banks.sections.bank_info') }}</h3>
                <a href="{{ route('admin.banks.edit', $bank->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm">
                    {{ __('admin/components.buttons.edit') }}
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/banks.fields.id') }}</p>
                    <p class="text-lg font-semibold">{{ $bank->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/banks.fields.name') }}</p>
                    <p class="text-lg font-semibold">{{ $bank->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/banks.fields.logo') }}</p>
                    <p class="text-lg font-semibold">{{ $bank->logo ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="flex gap-3 pt-6 border-t">
                <a href="{{ route('admin.banks.edit', $bank->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.edit') }}
                </a>
                <a href="{{ route('admin.banks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.back') }}
                </a>
            </div>
        </div>
    </x-card>
</x-layouts.admin>
