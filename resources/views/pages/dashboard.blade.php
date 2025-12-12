<x-layouts.admin header-title="Dashboard">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        <!-- Stat Card 1 -->
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">1,234</p>
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

        <!-- Stat Card 2 -->
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">$45,231</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </x-card>

        <!-- Stat Card 3 -->
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Orders</p>
                    <p class="text-2xl font-bold text-gray-900">892</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </x-card>

        <!-- Stat Card 4 -->
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Sessions</p>
                    <p class="text-2xl font-bold text-gray-900">342</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </x-card>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Recent Activity Card -->
        <x-card title="Recent Activity">
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-600 font-semibold">JD</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">John Doe created a new user</p>
                        <p class="text-xs text-gray-500">2 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-green-600 font-semibold">JS</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Jane Smith updated settings</p>
                        <p class="text-xs text-gray-500">15 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-yellow-600 font-semibold">AB</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Alice Brown deleted a record</p>
                        <p class="text-xs text-gray-500">1 hour ago</p>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Quick Actions Card -->
        <x-card title="Quick Actions">
            <div class="space-y-3">
                <x-button variant="primary" size="md" class="w-full justify-center">
                    Create New User
                </x-button>
                <x-button variant="secondary" size="md" class="w-full justify-center">
                    View Reports
                </x-button>
                <x-button variant="outline" size="md" class="w-full justify-center">
                    Export Data
                </x-button>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-semibold text-gray-900 mb-3">System Status</h4>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Server Status</span>
                        <x-badge variant="success" size="sm">Online</x-badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Database</span>
                        <x-badge variant="success" size="sm">Connected</x-badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Cache</span>
                        <x-badge variant="warning" size="sm">Clearing</x-badge>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Alerts Example -->
    <div class="mt-6 space-y-4">
        <x-alert type="success" dismissible>
            <strong>Success!</strong> Your changes have been saved.
        </x-alert>
        <x-alert type="info">
            <strong>Info:</strong> System maintenance scheduled for tonight.
        </x-alert>
    </div>
</x-layouts.admin>