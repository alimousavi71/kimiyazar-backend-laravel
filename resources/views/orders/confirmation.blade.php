@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="{{ __('orders.confirmation.title') }} - {{ $siteTitle }}" dir="rtl">
    <x-web.page-banner :title="__('orders.confirmation.title')" />
    
    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-2xl mx-auto">
                    
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 mb-6">
                        <div class="flex items-start gap-4">
                            <i class="fa fa-check-circle text-emerald-500 text-4xl mt-1"></i>
                            <div>
                                <h2 class="text-2xl font-bold text-emerald-800 mb-1">{{ __('orders.confirmation.success_title') }}</h2>
                                <p class="text-emerald-700">{{ __('orders.confirmation.success_message') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fa fa-receipt text-emerald-600"></i>
                            {{ __('orders.confirmation.order_details') }}
                        </h3>
                        
                        <div class="space-y-3 border-b border-gray-200 pb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-medium">{{ __('orders.fields.order_number') }}:</span>
                                <span class="font-bold text-lg text-gray-900">#{{ $order->id }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-medium">{{ __('orders.fields.status') }}:</span>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                    {{ $order->status->label() }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-start">
                                <span class="text-gray-600 font-medium">{{ __('orders.fields.customer_type') }}:</span>
                                <span class="text-gray-900">
                                    @if($order->customer_type === 'real')
                                        <i class="fa fa-user text-blue-500 me-2"></i>{{ __('orders.customer_types.real') }}
                                    @else
                                        <i class="fa fa-building text-blue-500 me-2"></i>{{ __('orders.customer_types.legal') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        
                        <div class="py-4 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-3">{{ __('orders.confirmation.product_info') }}</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">{{ __('orders.fields.product') }}:</span>
                                    <span class="font-semibold text-gray-900">{{ $order->product->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">{{ __('orders.fields.quantity') }}:</span>
                                    <span class="font-semibold text-gray-900">{{ $order->quantity }} {{ $order->unit }}</span>
                                </div>
                                @if($order->unit_price)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">{{ __('orders.fields.unit_price') }}:</span>
                                    <span class="font-semibold text-gray-900">{{ number_format($order->unit_price) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        
                        <div class="py-4">
                            <h4 class="font-semibold text-gray-900 mb-3">{{ __('orders.confirmation.customer_info') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                @if($order->full_name)
                                <div>
                                    <span class="text-gray-600">{{ __('orders.fields.full_name') }}:</span>
                                    <p class="font-medium text-gray-900">{{ $order->full_name }}</p>
                                </div>
                                @endif
                                
                                @if($order->phone)
                                <div>
                                    <span class="text-gray-600">{{ __('orders.fields.phone') }}:</span>
                                    <p class="font-medium text-gray-900 dir-ltr">{{ $order->phone }}</p>
                                </div>
                                @endif
                                
                                @if($order->mobile)
                                <div>
                                    <span class="text-gray-600">{{ __('orders.fields.mobile') }}:</span>
                                    <p class="font-medium text-gray-900 dir-ltr">{{ $order->mobile }}</p>
                                </div>
                                @endif
                                
                                @if($order->company_name)
                                <div>
                                    <span class="text-gray-600">{{ __('orders.fields.company_name') }}:</span>
                                    <p class="font-medium text-gray-900">{{ $order->company_name }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                        <h4 class="font-semibold text-blue-900 mb-4 flex items-center gap-2">
                            <i class="fa fa-tasks text-blue-600"></i>
                            {{ __('orders.confirmation.next_steps') }}
                        </h4>
                        <ol class="list-decimal list-inside space-y-2 text-blue-900 text-sm">
                            <li>{{ __('orders.confirmation.step_1') }}</li>
                            <li>{{ __('orders.confirmation.step_2') }}</li>
                            <li>{{ __('orders.confirmation.step_3') }}</li>
                        </ol>
                    </div>

                    
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                        <p class="text-amber-900 text-sm">
                            <i class="fa fa-info-circle text-amber-600 me-2"></i>
                            {{ __('orders.confirmation.important_note') }}
                        </p>
                    </div>

                    
                    <div class="flex flex-col md:flex-row gap-3">
                        <a href="{{ route('home') }}" 
                           class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors font-semibold">
                            <i class="fa fa-home me-2"></i>{{ __('orders.confirmation.back_home') }}
                        </a>
                        @auth
                        <a href="{{ route('user.profile.show') }}" 
                           class="flex-1 text-center px-6 py-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors font-semibold">
                            <i class="fa fa-list me-2"></i>{{ __('orders.confirmation.view_orders') }}
                        </a>
                        @endauth
                        <a href="{{ route('products.index') }}" 
                           class="flex-1 text-center px-6 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors font-semibold">
                            <i class="fa fa-shopping-bag me-2"></i>{{ __('orders.confirmation.browse_products') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>
