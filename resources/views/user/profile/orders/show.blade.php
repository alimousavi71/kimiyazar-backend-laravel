<x-layouts.user-profile :title="__('user/orders.show.title')" :header-title="__('user/orders.show.header_title')"
    :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/orders.title'), 'url' => route('user.profile.orders.index')],
        ['label' => __('user/orders.show.title')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('user/orders.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('user/orders.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('user.profile.orders.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('user/orders.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="space-y-6">

        <x-card>
            <x-slot name="title">{{ __('user/orders.show.order_info') }}</x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.id') }}</label>
                    <p class="text-base text-gray-900 mt-1">#{{ $order->id }}</p>
                </div>
                <div>
                    <label
                        class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.customer_type') }}</label>
                    <p class="text-base text-gray-900 mt-1">
                        <x-badge :variant="$order->customer_type === 'real' ? 'info' : 'primary'">
                            {{ __('user/orders.customer_types.' . $order->customer_type) }}
                        </x-badge>
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.status') }}</label>
                    <div class="mt-1">
                        <x-badge :variant="$order->status->color()">
                            {{ __('user/orders.statuses.' . $order->status->value) }}
                        </x-badge>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.created_at') }}</label>
                    <p class="text-base text-gray-900 mt-1">
                        @if($order->created_at)
                            <x-date :date="\Carbon\Carbon::createFromTimestamp($order->created_at)" type="datetime-full" />
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </x-card>


        <x-card>
            <x-slot name="title">{{ __('user/orders.show.customer_info') }}</x-slot>

            <div class="space-y-4">
                @if ($order->customer_type === 'real')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.full_name') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->full_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.national_code') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->national_code ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.phone') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.mobile') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->mobile ?? 'N/A' }}</p>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.company_name') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->company_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.economic_code') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->economic_code ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.registration_number') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->registration_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </x-card>


        <x-card>
            <x-slot name="title">{{ __('user/orders.show.location_info') }}</x-slot>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.country') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $order->country?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.state') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $order->state?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.city') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $order->city ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.postal_code') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $order->postal_code ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.receiver_full_name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $order->receiver_full_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.delivery_method') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($order->delivery_method)
                                {{ __('user/orders.delivery_methods.' . $order->delivery_method) }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.address') }}</label>
                    <p class="text-base text-gray-900 mt-1">{{ $order->address ?? 'N/A' }}</p>
                </div>
            </div>
        </x-card>


        <x-card>
            <x-slot name="title">{{ __('user/orders.show.product_info') }}</x-slot>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.product') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($order->product)
                                <a href="{{ route('products.show', $order->product->slug) }}"
                                    class="text-blue-600 hover:text-blue-700">
                                    {{ $order->product->name }}
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.quantity') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $order->quantity ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.unit') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            {{ __('user/orders.units.' . $order->unit) }}
                        </p>
                    </div>
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.unit_price') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            @if($order->unit_price)
                                {{ number_format($order->unit_price) }} {{ __('orders.currency') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
                @if ($order->product_description)
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.product_description') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $order->product_description }}</p>
                    </div>
                @endif
            </div>
        </x-card>


        <x-card>
            <x-slot name="title">{{ __('user/orders.show.payment_info') }}</x-slot>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.payment_type') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            {{ __('user/orders.payment_types.' . $order->payment_type->value) }}
                        </p>
                    </div>
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.total_payment_amount') }}</label>
                        <p class="text-base text-gray-900 mt-1 font-semibold">
                            {{ number_format($order->total_payment_amount) }} {{ __('orders.currency') }}
                        </p>
                    </div>
                    @if($order->payment_date)
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.payment_date') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->payment_date }}</p>
                        </div>
                    @endif
                    @if($order->payment_time)
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('user/orders.fields.payment_time') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $order->payment_time }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </x-card>
    </div>
</x-layouts.user-profile>