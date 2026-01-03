<x-layouts.user-profile :title="__('user/orders.title')" :header-title="__('user/orders.title')" :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/orders.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('user/orders.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('user/orders.description') }}</p>
            </div>
        </div>


        <x-session-messages />


        <x-card>
            <x-table-wrapper :paginator="$orders ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('user/orders.fields.id') }}</x-table.cell>
                            <x-table.cell header>{{ __('user/orders.fields.customer_type') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="status">{{ __('user/orders.fields.status') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="payment_type">{{ __('user/orders.fields.payment_type') }}</x-table.cell>
                            <x-table.cell header>{{ __('user/orders.fields.total_payment_amount') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('user/orders.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($orders) && $orders->count() > 0)
                            @foreach($orders as $order)
                                <x-table.row>
                                    <x-table.cell>
                                        <span class="text-gray-600">#{{ $order->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <x-badge :variant="$order->customer_type === 'real' ? 'info' : 'primary'">
                                            {{ __('user/orders.customer_types.' . $order->customer_type) }}
                                        </x-badge>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <x-badge :variant="$order->status->color()">
                                            {{ __('user/orders.statuses.' . $order->status->value) }}
                                        </x-badge>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span
                                            class="text-gray-700">{{ __('user/orders.payment_types.' . $order->payment_type->value) }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span
                                            class="text-gray-900 font-medium">{{ number_format($order->total_payment_amount) }}
                                            {{ __('orders.currency') }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-900">
                                            @if($order->created_at)
                                                <x-date :date="\Carbon\Carbon::createFromTimestamp($order->created_at)" type="datetime" />
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('user.profile.orders.show', $order->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                            </x-dropdown-menu>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        @else
                            <x-table.row>
                                <x-table.cell colspan="7" class="text-center py-8 text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>
        </x-card>
    </div>
</x-layouts.user-profile>