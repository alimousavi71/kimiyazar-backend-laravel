@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="{{ __('orders.forms.create_legal.title') }} - {{ $siteTitle }}" dir="rtl">
    <x-web.page-banner :title="__('orders.forms.create_legal.title')" />

    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('orders.forms.product_info') }}</h3>
                        <div class="flex items-center gap-6">
                            @if($product->mainPhoto)
                                <img src="{{ $product->mainPhoto->path }}" alt="{{ $product->name }}" 
                                     class="w-32 h-32 object-cover rounded-lg shadow-sm">
                            @else
                                <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <i class="fa fa-image text-gray-400 text-3xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h4>
                                @if($product->latestPrice)
                                    <p class="text-gray-600 mb-2">
                                        <span class="font-semibold text-xl text-emerald-600">
                                            {{ number_format($product->latestPrice->price) }}
                                        </span>
                                        <span class="text-gray-500">{{ __('orders.currency') }}</span>
                                    </p>
                                @endif
                                @if($product->category)
                                    <p class="text-sm text-gray-500">
                                        {{ __('orders.fields.category') }}: 
                                        <span class="font-medium text-gray-700">{{ $product->category->name }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white rounded-xl shadow-md overflow-visible">
                        
                        @if($errors->any())
                            <div class="bg-red-50 border-b border-red-200 p-6">
                                <div class="flex items-start gap-3">
                                    <i class="fa fa-exclamation-circle text-red-500 text-xl mt-1"></i>
                                    <div>
                                        <h4 class="font-semibold text-red-800 mb-2">{{ __('orders.forms.form_error') }}</h4>
                                        <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form id="order-form-legal" 
                              action="{{ route('orders.store.legal', ['productSlug' => $product->slug]) }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              class="p-6 space-y-6">
                            @csrf

                            
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fa fa-user-circle text-emerald-600"></i>
                                    {{ __('orders.forms.contact_info') }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-form-group :label="__('orders.fields.full_name')" required :error="$errors->first('full_name')">
                                        <x-input type="text" name="full_name" id="full_name"
                                            :value="old('full_name', $user ? $user->first_name . ' ' . $user->last_name : '')"
                                            :disabled="(bool) $user"
                                            class="w-full" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.phone')" required :error="$errors->first('phone')">
                                        <x-input type="text" name="phone" id="phone"
                                            :value="old('phone', $user->phone_number ?? '')"
                                            :disabled="(bool) $user"
                                            placeholder="+98..."
                                            class="w-full" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.mobile')" :error="$errors->first('mobile')">
                                        <x-input type="text" name="mobile" id="mobile"
                                            :value="old('mobile')"
                                            placeholder="09xxxxxxxxx"
                                            class="w-full" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.email')" :error="$errors->first('email')">
                                        <x-input type="email" name="email" id="email"
                                            :value="old('email', $user->email ?? '')"
                                            :disabled="(bool) $user"
                                            class="w-full" />
                                    </x-form-group>
                                </div>
                                
                                @if($user)
                                    <input type="hidden" name="full_name" value="{{ $user->first_name }} {{ $user->last_name }}">
                                    <input type="hidden" name="phone" value="{{ $user->phone_number ?? '' }}">
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                @endif
                            </div>

                            
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fa fa-building text-emerald-600"></i>
                                    {{ __('orders.forms.company_legal_info') }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-form-group :label="__('orders.fields.company_name')" required :error="$errors->first('company_name')">
                                        <x-input type="text" name="company_name" id="company_name"
                                            :value="old('company_name')"
                                            class="w-full" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.economic_code')" required :error="$errors->first('economic_code')">
                                        <x-input type="text" name="economic_code" id="economic_code"
                                            :value="old('economic_code')"
                                            placeholder="000000000000"
                                            maxlength="12"
                                            class="w-full" />
                                        <p class="mt-1 text-xs text-gray-500">{{ __('orders.validation.economic_code_numeric') }}</p>
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.registration_number')" required :error="$errors->first('registration_number')">
                                        <x-input type="number" name="registration_number" id="registration_number"
                                            :value="old('registration_number')"
                                            class="w-full" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.official_gazette_photo')" required :error="$errors->first('official_gazette_photo')">
                                        <input type="file" name="official_gazette_photo" id="official_gazette_photo"
                                            accept="image/jpeg,image/png,image/jpg,application/pdf"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none focus:border-emerald-500 p-2" />
                                        <p class="mt-1 text-xs text-gray-500">{{ __('orders.forms.file_help') }}</p>
                                    </x-form-group>
                                </div>
                            </div>

                            
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fa fa-map-marker-alt text-emerald-600"></i>
                                    {{ __('orders.forms.delivery_address') }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-form-group :label="__('orders.fields.country')" required :error="$errors->first('country_id')">
                                        <x-select2 id="country_id" name="country_id"
                                            remote-url="{{ route('api.countries.search') }}"
                                            remote-search 
                                            :min-input-length="0"
                                            value-key="id" 
                                            text-key="name"
                                            :placeholder="__('orders.forms.select_country')" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.state')" required :error="$errors->first('state_id')">
                                        <x-select2 id="state_id" name="state_id"
                                            remote-url="{{ route('api.states.search') }}"
                                            remote-search 
                                            depends-on="country_id"
                                            value-key="id" 
                                            text-key="name"
                                            :placeholder="__('orders.forms.select_state')" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.city')" required :error="$errors->first('city')">
                                        <x-input type="text" name="city" id="city" 
                                            :value="old('city')"
                                            class="w-full" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.postal_code')" required :error="$errors->first('postal_code')">
                                        <x-input type="text" name="postal_code" id="postal_code"
                                            :value="old('postal_code')" 
                                            placeholder="0000000000" 
                                            maxlength="10"
                                            class="w-full" />
                                        <p class="mt-1 text-xs text-gray-500">{{ __('orders.validation.postal_code_size') }}</p>
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.receiver_name')" required :error="$errors->first('receiver_full_name')">
                                        <x-input type="text" name="receiver_full_name" id="receiver_full_name"
                                            :value="old('receiver_full_name')"
                                            class="w-full" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.delivery_method')" required :error="$errors->first('delivery_method')">
                                        <x-select name="delivery_method" id="delivery_method">
                                            <option value="">{{ __('orders.forms.select_delivery') }}</option>
                                            <option value="post" @selected(old('delivery_method') === 'post')>{{ __('orders.delivery.post') }}</option>
                                            <option value="courier" @selected(old('delivery_method') === 'courier')>{{ __('orders.delivery.courier') }}</option>
                                            <option value="in_person" @selected(old('delivery_method') === 'in_person')>{{ __('orders.delivery.in_person') }}</option>
                                        </x-select>
                                    </x-form-group>
                                </div>
                                
                                <div class="mt-4">
                                    <x-form-group :label="__('orders.fields.address')" required :error="$errors->first('address')">
                                        <x-textarea name="address" id="address" rows="3"
                                            :value="old('address')" />
                                    </x-form-group>
                                </div>
                            </div>

                            
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fa fa-box text-emerald-600"></i>
                                    {{ __('orders.forms.product_details') }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-form-group :label="__('orders.fields.quantity')" required :error="$errors->first('quantity')">
                                        <x-input type="number" name="quantity" id="quantity"
                                            :value="old('quantity', 1)" 
                                            min="1"
                                            class="w-full" />
                                    </x-form-group>
                                    
                                    <x-form-group :label="__('orders.fields.unit')" required :error="$errors->first('unit')">
                                        <x-select name="unit" id="unit" :placeholder="__('orders.forms.select_unit')">
                                            @foreach(\App\Enums\Database\ProductUnit::cases() as $unit)
                                                <option value="{{ $unit->value }}" @selected(old('unit') === $unit->value)>
                                                    {{ $unit->label() }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </x-form-group>
                                </div>
                                
                                <div class="mt-4">
                                    <x-form-group :label="__('orders.fields.product_description')" :error="$errors->first('product_description')">
                                        <x-textarea name="product_description" id="product_description" rows="3"
                                            :value="old('product_description')"
                                            :placeholder="__('orders.forms.description_help')" />
                                    </x-form-group>
                                </div>
                            </div>

                            
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors font-semibold">
                                    <i class="fa fa-arrow-right me-2"></i>{{ __('orders.forms.back') }}
                                </a>
                                <button type="submit"
                                    class="px-8 py-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors font-semibold shadow-md hover:shadow-lg">
                                    <i class="fa fa-check me-2"></i>{{ __('orders.forms.submit_order') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>
