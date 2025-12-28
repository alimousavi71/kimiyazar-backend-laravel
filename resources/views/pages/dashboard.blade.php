<x-layouts.admin :header-title="__('dashboard.header')">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">{{ __('dashboard.stats.total_users') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </x-card>

        
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">{{ __('dashboard.stats.total_products') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                        </path>
                    </svg>
                </div>
            </div>
        </x-card>

        
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">{{ __('dashboard.stats.total_orders') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </x-card>

        
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">{{ __('dashboard.stats.total_categories') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalCategories) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                </div>
            </div>
        </x-card>
    </div>

    
    <div class="grid gap-6 sm:grid-cols-2 mb-6">
        
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">{{ __('dashboard.stats.pending_orders') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($pendingOrders) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </x-card>

        
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">{{ __('dashboard.stats.paid_orders') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($paidOrders) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </x-card>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        
        <x-card :title="__('dashboard.recent_orders.title')">
            <div class="space-y-4">
                @forelse($recentOrders as $order)
                    <div class="flex items-start gap-4">
                        @php
                            $name = $order->customer_type === 'real' ? $order->full_name : $order->company_name;
                            $parts = explode(' ', trim($name));
                            $initials = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? $parts[0] ?? '', 0, 1));
                            $statusValue = $order->status->value ?? $order->status;
                            $statusColor = $statusValue === 'pending_payment' ? 'orange' : ($statusValue === 'paid' ? 'emerald' : 'blue');
                            $badgeVariant = $statusValue === 'pending_payment' ? 'warning' : ($statusValue === 'paid' ? 'success' : 'default');
                        @endphp
                        <div class="w-10 h-10 bg-{{ $statusColor }}-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-{{ $statusColor }}-600 font-semibold text-xs">{{ $initials }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                <strong>{{ $name }}</strong> {{ __('dashboard.recent_orders.ordered') }} <strong>{{ $order->product?->name ?? 'Product' }}</strong>
                            </p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::createFromTimestamp($order->created_at)->diffForHumans() }}</p>
                        </div>
                        <div>
                            <x-badge
                                variant="{{ $badgeVariant }}"
                                size="sm">
                                {{ __('orders.statuses.' . $statusValue) }}
                            </x-badge>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">{{ __('dashboard.recent_orders.empty') }}</p>
                @endforelse
            </div>
        </x-card>
    </div>
</x-layouts.admin>