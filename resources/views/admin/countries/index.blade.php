<x-layouts.admin :title="__('admin/countries.title')" :header-title="__('admin/countries.title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
    ['label' => __('admin/countries.title')]
]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/countries.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/countries.description') }}</p>
            </div>
            <a href="{{ route('admin.countries.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/countries.add_new') }}
                </x-button>
            </a>
        </div>

        <x-session-messages />

        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                :paginator="$countries ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable sort-field="name">{{ __('admin/countries.fields.name') }}</x-table.cell>
                            <x-table.cell header sortable sort-field="code">{{ __('admin/countries.fields.code') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @forelse($countries->items() ?? [] as $country)
                            <x-table.row>
                                <x-table.cell class="font-medium">{{ $country->id }}</x-table.cell>
                                <x-table.cell>{{ $country->name }}</x-table.cell>
                                <x-table.cell>{{ $country->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('admin.countries.show', $country->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <x-icon name="eye" class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.countries.edit', $country->id) }}" class="text-amber-600 hover:text-amber-800">
                                            <x-icon name="pencil" class="w-4 h-4" />
                                        </a>
                                        <form method="POST" action="{{ route('admin.countries.destroy', $country->id) }}" class="inline" onsubmit="return confirm('{{ __('admin/components.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <x-icon name="trash-2" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="4" class="text-center text-gray-500 py-8">
                                    {{ __('admin/components.no_data') }}
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-table.body>
                </x-table>
            </x-table-wrapper>
        </x-card>
    </div>
</x-layouts.admin>
