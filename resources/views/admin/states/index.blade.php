<x-layouts.admin :title="__('admin/states.title')" :header-title="__('admin/states.title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
    ['label' => __('admin/states.title')]
]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/states.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/states.description') }}</p>
            </div>
            <a href="{{ route('admin.states.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/states.add_new') }}
                </x-button>
            </a>
        </div>

        <x-session-messages />

        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                :paginator="$states ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable sort-field="name">{{ __('admin/states.fields.name') }}</x-table.cell>
                            <x-table.cell header sortable sort-field="country_id">{{ __('admin/states.fields.country_id') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @forelse($states->items() ?? [] as $state)
                            <x-table.row>
                                <x-table.cell class="font-medium">{{ $state->id }}</x-table.cell>
                                <x-table.cell>{{ $state->name }}</x-table.cell>
                                <x-table.cell>{{ $state->country->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('admin.states.show', $state->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <x-icon name="eye" class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.states.edit', $state->id) }}" class="text-amber-600 hover:text-amber-800">
                                            <x-icon name="pencil" class="w-4 h-4" />
                                        </a>
                                        <form method="POST" action="{{ route('admin.states.destroy', $state->id) }}" class="inline" onsubmit="return confirm('{{ __('admin/components.confirm_delete') }}')">
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
