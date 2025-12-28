<x-layouts.admin :title="__('admin/orders.create_title')" :header-title="__('admin/orders.create_title')" :breadcrumbs="[
    ['label' => __('admin/components.buttons.back'), 'url' => route('admin.orders.index')],
    ['label' => __('admin/orders.create_title')]
]">
    <x-card>
        <form action="{{ route('admin.orders.store') }}" method="POST" class="space-y-6">
            @csrf

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-select
                    name="customer_type"
                    :label="__('admin/orders.fields.customer_type')"
                    required
                    :error="$errors->first('customer_type')"
                >
                    <option value="real">{{ __('admin/orders.customer_types.real') }}</option>
                    <option value="legal">{{ __('admin/orders.customer_types.legal') }}</option>
                </x-select>

                <x-input
                    name="member_id"
                    :label="__('admin/orders.fields.member_id')"
                    type="number"
                    :error="$errors->first('member_id')"
                />
            </div>

            
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('admin/orders.sections.individual_info') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input
                        name="full_name"
                        :label="__('admin/orders.fields.full_name')"
                        :error="$errors->first('full_name')"
                    />
                    <x-input
                        name="national_code"
                        :label="__('admin/orders.fields.national_code')"
                        :error="$errors->first('national_code')"
                    />
                    <x-input
                        name="phone"
                        :label="__('admin/orders.fields.phone')"
                        :error="$errors->first('phone')"
                    />
                    <x-input
                        name="mobile"
                        :label="__('admin/orders.fields.mobile')"
                        :error="$errors->first('mobile')"
                    />
                </div>
            </div>

            
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('admin/orders.sections.company_info') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input
                        name="company_name"
                        :label="__('admin/orders.fields.company_name')"
                        :error="$errors->first('company_name')"
                    />
                    <x-input
                        name="economic_code"
                        :label="__('admin/orders.fields.economic_code')"
                        :error="$errors->first('economic_code')"
                    />
                    <x-input
                        name="registration_number"
                        :label="__('admin/orders.fields.registration_number')"
                        type="number"
                        :error="$errors->first('registration_number')"
                    />
                </div>
            </div>

            
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('admin/orders.sections.location_info') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input
                        name="city"
                        :label="__('admin/orders.fields.city')"
                        :error="$errors->first('city')"
                    />
                    <x-input
                        name="postal_code"
                        :label="__('admin/orders.fields.postal_code')"
                        :error="$errors->first('postal_code')"
                    />
                </div>
                <div class="mt-6">
                    <x-textarea
                        name="address"
                        :label="__('admin/orders.fields.address')"
                        :error="$errors->first('address')"
                    />
                </div>
            </div>

            
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('admin/orders.sections.receiver_info') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input
                        name="receiver_full_name"
                        :label="__('admin/orders.fields.receiver_full_name')"
                        :error="$errors->first('receiver_full_name')"
                    />
                    <x-input
                        name="delivery_method"
                        :label="__('admin/orders.fields.delivery_method')"
                        :error="$errors->first('delivery_method')"
                    />
                </div>
            </div>

            
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('admin/orders.sections.product_info') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input
                        name="product_id"
                        :label="__('admin/orders.fields.product_id')"
                        type="number"
                        :error="$errors->first('product_id')"
                    />
                    <x-input
                        name="quantity"
                        :label="__('admin/orders.fields.quantity')"
                        type="number"
                        :error="$errors->first('quantity')"
                    />
                    <x-select
                        name="unit"
                        :label="__('admin/orders.fields.unit')"
                        :error="$errors->first('unit')"
                    >
                        <option value="piece">{{ __('admin/orders.units.piece') }}</option>
                        <option value="kg">{{ __('admin/orders.units.kg') }}</option>
                        <option value="gram">{{ __('admin/orders.units.gram') }}</option>
                        <option value="liter">{{ __('admin/orders.units.liter') }}</option>
                        <option value="meter">{{ __('admin/orders.units.meter') }}</option>
                        <option value="box">{{ __('admin/orders.units.box') }}</option>
                        <option value="set">{{ __('admin/orders.units.set') }}</option>
                        <option value="pair">{{ __('admin/orders.units.pair') }}</option>
                    </x-select>
                    <x-input
                        name="unit_price"
                        :label="__('admin/orders.fields.unit_price')"
                        type="number"
                        step="0.01"
                        :error="$errors->first('unit_price')"
                    />
                </div>
                <div class="mt-6">
                    <x-textarea
                        name="product_description"
                        :label="__('admin/orders.fields.product_description')"
                        :error="$errors->first('product_description')"
                    />
                </div>
            </div>

            
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('admin/orders.sections.payment_info') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-select
                        name="payment_type"
                        :label="__('admin/orders.fields.payment_type')"
                        required
                        :error="$errors->first('payment_type')"
                    >
                        <option value="online_gateway">{{ __('admin/orders.payment_types.online_gateway') }}</option>
                        <option value="bank_deposit">{{ __('admin/orders.payment_types.bank_deposit') }}</option>
                        <option value="wallet">{{ __('admin/orders.payment_types.wallet') }}</option>
                        <option value="pos">{{ __('admin/orders.payment_types.pos') }}</option>
                        <option value="cash_on_delivery">{{ __('admin/orders.payment_types.cash_on_delivery') }}</option>
                    </x-select>
                    <x-input
                        name="payment_bank_id"
                        :label="__('admin/orders.fields.payment_bank_id')"
                        type="number"
                        :error="$errors->first('payment_bank_id')"
                    />
                    <x-input
                        name="total_payment_amount"
                        :label="__('admin/orders.fields.total_payment_amount')"
                        :error="$errors->first('total_payment_amount')"
                    />
                    <x-input
                        name="payment_date"
                        :label="__('admin/orders.fields.payment_date')"
                        type="date"
                        :error="$errors->first('payment_date')"
                    />
                    <x-input
                        name="payment_time"
                        :label="__('admin/orders.fields.payment_time')"
                        type="time"
                        :error="$errors->first('payment_time')"
                    />
                </div>
            </div>

            
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('admin/orders.sections.administration') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-select
                        name="status"
                        :label="__('admin/orders.fields.status')"
                        required
                        :error="$errors->first('status')"
                    >
                        <option value="pending_payment">{{ __('admin/orders.statuses.pending_payment') }}</option>
                        <option value="paid">{{ __('admin/orders.statuses.paid') }}</option>
                        <option value="processing">{{ __('admin/orders.statuses.processing') }}</option>
                        <option value="shipped">{{ __('admin/orders.statuses.shipped') }}</option>
                        <option value="delivered">{{ __('admin/orders.statuses.delivered') }}</option>
                        <option value="cancelled">{{ __('admin/orders.statuses.cancelled') }}</option>
                        <option value="returned">{{ __('admin/orders.statuses.returned') }}</option>
                    </x-select>
                </div>
                <div class="mt-6">
                    <x-textarea
                        name="admin_note"
                        :label="__('admin/orders.fields.admin_note')"
                        :error="$errors->first('admin_note')"
                    />
                </div>
            </div>

            
            <div class="border-t pt-6 flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.save') }}
                </button>
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    {{ __('admin/components.buttons.cancel') }}
                </a>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
