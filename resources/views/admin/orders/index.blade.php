<x-layouts.admin :title="__('admin/orders.title')" :header-title="__('admin/orders.title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
    ['label' => __('admin/orders.title')]
]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/orders.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/orders.description') }}</p>
            </div>
            <a href="{{ route('admin.orders.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/orders.add_new') }}
                </x-button>
            </a>
        </div>

        <!-- Success/Error Messages -->
        <x-session-messages />

        <!-- Orders Table -->
        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="orders-filters" :filter-badges="[
                'customer_type' => __('admin/orders.fields.customer_type'),
                'status' => __('admin/orders.fields.status'),
                'payment_type' => __('admin/orders.fields.payment_type'),
                'is_viewed' => __('admin/orders.fields.is_viewed'),
            ]" :paginator="$orders ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/orders.fields.customer_name') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="customer_type">{{ __('admin/orders.fields.customer_type') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="status">{{ __('admin/orders.fields.status') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="payment_type">{{ __('admin/orders.fields.payment_type') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/orders.fields.total_payment') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_viewed">{{ __('admin/orders.fields.is_viewed') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @forelse($orders->items() ?? [] as $order)
                            <x-table.row>
                                <x-table.cell class="font-medium">{{ $order->id }}</x-table.cell>
                                <x-table.cell>{{ $order->full_name ?? $order->company_name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>
                                    <x-badge
                                        :variant="$order->customer_type === 'real' ? 'info' : 'primary'">
                                        {{ __('admin/orders.customer_types.' . $order->customer_type) }}
                                    </x-badge>
                                </x-table.cell>
                                <x-table.cell>
                                    <x-badge :variant="$order->status->color()">
                                        {{ __('admin/orders.statuses.' . $order->status->value) }}
                                    </x-badge>
                                </x-table.cell>
                                <x-table.cell>
                                    {{ __('admin/orders.payment_types.' . $order->payment_type->value) }}
                                </x-table.cell>
                                <x-table.cell>{{ $order->total_payment_amount }}</x-table.cell>
                                <x-table.cell>
                                    <x-badge :variant="$order->is_viewed ? 'success' : 'warning'">
                                        {{ $order->is_viewed ? __('admin/orders.viewed') : __('admin/orders.unviewed') }}
                                    </x-badge>
                                </x-table.cell>
                                <x-table.cell class="text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <x-icon name="eye" class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-amber-600 hover:text-amber-800">
                                            <x-icon name="pencil" class="w-4 h-4" />
                                        </a>
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" class="inline" onsubmit="return confirm('{{ __('admin/components.confirm_delete') }}')">
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
                                <x-table.cell colspan="8" class="text-center text-gray-500 py-8">
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
