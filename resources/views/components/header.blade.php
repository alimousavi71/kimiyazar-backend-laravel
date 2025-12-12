@props(['title' => null])

<header class="bg-white shadow-sm border-b border-gray-100">
    <div class="px-4 sm:px-6 lg:px-8 py-2.5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <x-icon-button icon="menu" size="lg" variant="default"
                    onclick="document.dispatchEvent(new CustomEvent('toggle-sidebar'))" class="lg:hidden"
                    aria-label="Toggle sidebar" />
                @if($title)
                    <h1 class="text-lg font-semibold text-gray-900">{{ $title }}</h1>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <!-- Notifications Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <x-icon-button icon="bell" size="lg" variant="default" :badge="true" badge-color="red"
                        @click="open = !open" aria-label="Notifications" />

                    <!-- Notifications Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition x-cloak
                        class="absolute end-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden"
                        style="display: none;">
                        <!-- Header -->
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                            <x-icon-button icon="x" size="sm" variant="secondary" @click="open = false"
                                aria-label="Close notifications" />
                        </div>

                        <!-- Notifications List -->
                        <div class="max-h-96 overflow-y-auto">
                            <!-- Example Notifications -->
                            <x-notification-item title="New user registered" description="John Doe just signed up"
                                time="2 minutes ago" icon="user" icon-color="blue" unread="true" />

                            <x-notification-item title="Order completed" description="Order #1234 has been completed"
                                time="15 minutes ago" icon="check" icon-color="green" />

                            <x-notification-item title="System alert" description="High server load detected"
                                time="1 hour ago" icon="alert" icon-color="yellow" />

                            <x-notification-item title="New message" description="You have a new message from support"
                                time="3 hours ago" icon="message" icon-color="purple" />
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 text-center block">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                @php
                    $admin = auth('admin')->user() ?? auth()->user();
                    $adminName = $admin ? $admin->full_name : 'Admin User';
                    $adminEmail = $admin ? $admin->email : 'admin@example.com';
                    $adminInitials = $admin ? strtoupper(substr($admin->first_name, 0, 1) . substr($admin->last_name, 0, 1)) : 'A';
                @endphp
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors p-1.5 rounded-xl hover:bg-gray-100"
                        aria-label="User menu">
                        <div
                            class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                            {{ $adminInitials }}
                        </div>
                        <x-icon name="chevron-down" size="sm" class="hidden sm:block" />
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition x-cloak
                        class="absolute end-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 py-1.5 z-50 overflow-hidden"
                        style="display: none;">
                        <!-- User Info Header -->
                        <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-indigo-50/50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                                    {{ $adminInitials }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $adminName }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $adminEmail }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <x-icon name="user" size="md" />
                            <span>Profile</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <x-icon name="cog" size="md" />
                            <span>Settings</span>
                        </a>
                        <hr class="my-1 border-gray-100">
                        <a href="#"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <x-icon name="log-out" size="md" />
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>