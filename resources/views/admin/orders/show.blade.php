<x-layouts.admin :title="__('admin/orders.show_title')" :header-title="__('admin/orders.show_title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.orders.index')],
    ['label' => __('admin/orders.show_title')]
]">
    <div class="space-y-4">
        <!-- Basic Information -->
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">{{ __('admin/orders.sections.order_info') }}</h3>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm">
                    {{ __('admin/components.buttons.edit') }}
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.id') }}</p>
                    <p class="text-lg font-semibold">{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.customer_type') }}</p>
                    <p class="text-lg font-semibold">{{ __('admin/orders.customer_types.' . $order->customer_type) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.status') }}</p>
                    <x-badge :variant="$order->status->color()">
                        {{ __('admin/orders.statuses.' . $order->status->value) }}
                    </x-badge>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.is_viewed') }}</p>
                    <x-badge :variant="$order->is_viewed ? 'success' : 'warning'">
                        {{ $order->is_viewed ? __('admin/orders.viewed') : __('admin/orders.unviewed') }}
                    </x-badge>
                </div>
            </div>
        </x-card>

        <!-- Customer Information -->
        <x-card>
            <h3 class="text-lg font-semibold mb-6">{{ __('admin/orders.sections.customer_info') }}</h3>
            @if ($order->customer_type === 'real')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">{{ __('admin/orders.fields.full_name') }}</p>
                        <p class="text-lg">{{ $order->full_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('admin/orders.fields.national_code') }}</p>
                        <p class="text-lg">{{ $order->national_code ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('admin/orders.fields.phone') }}</p>
                        <p class="text-lg">{{ $order->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('admin/orders.fields.mobile') }}</p>
                        <p class="text-lg">{{ $order->mobile ?? 'N/A' }}</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">{{ __('admin/orders.fields.company_name') }}</p>
                        <p class="text-lg">{{ $order->company_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('admin/orders.fields.economic_code') }}</p>
                        <p class="text-lg">{{ $order->economic_code ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('admin/orders.fields.registration_number') }}</p>
                        <p class="text-lg">{{ $order->registration_number ?? 'N/A' }}</p>
                    </div>
                </div>
            @endif
        </x-card>

        <!-- Location & Receiver Information -->
        <x-card>
            <h3 class="text-lg font-semibold mb-6">{{ __('admin/orders.sections.location_receiver_info') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.city') }}</p>
                    <p class="text-lg">{{ $order->city ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.postal_code') }}</p>
                    <p class="text-lg">{{ $order->postal_code ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.receiver_full_name') }}</p>
                    <p class="text-lg">{{ $order->receiver_full_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.delivery_method') }}</p>
                    <p class="text-lg">{{ $order->delivery_method ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-sm text-gray-600">{{ __('admin/orders.fields.address') }}</p>
                <p class="text-lg">{{ $order->address ?? 'N/A' }}</p>
            </div>
        </x-card>

        <!-- Product Information -->
        <x-card>
            <h3 class="text-lg font-semibold mb-6">{{ __('admin/orders.sections.product_info') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.product_id') }}</p>
                    <p class="text-lg">{{ $order->product_id ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.quantity') }}</p>
                    <p class="text-lg">{{ $order->quantity ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.unit') }}</p>
                    <p class="text-lg">{{ __('admin/orders.units.' . $order->unit) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.unit_price') }}</p>
                    <p class="text-lg">{{ $order->unit_price ?? 'N/A' }}</p>
                </div>
            </div>
            @if ($order->product_description)
                <div class="mt-6">
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.product_description') }}</p>
                    <p class="text-lg">{{ $order->product_description }}</p>
                </div>
            @endif
        </x-card>

        <!-- Payment Information -->
        <x-card>
            <h3 class="text-lg font-semibold mb-6">{{ __('admin/orders.sections.payment_info') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.payment_type') }}</p>
                    <p class="text-lg">{{ __('admin/orders.payment_types.' . $order->payment_type->value) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.total_payment_amount') }}</p>
                    <p class="text-lg">{{ $order->total_payment_amount ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.payment_date') }}</p>
                    <p class="text-lg">{{ $order->payment_date ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin/orders.fields.payment_time') }}</p>
                    <p class="text-lg">{{ $order->payment_time ?? 'N/A' }}</p>
                </div>
            </div>
        </x-card>

        <!-- Admin Notes -->
        @if ($order->admin_note)
            <x-card>
                <h3 class="text-lg font-semibold mb-6">{{ __('admin/orders.fields.admin_note') }}</h3>
                <p class="text-lg">{{ $order->admin_note }}</p>
            </x-card>
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg">
                {{ __('admin/components.buttons.edit') }}
            </a>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                {{ __('admin/components.buttons.back') }}
            </a>
        </div>
    </div>
</x-layouts.admin>
