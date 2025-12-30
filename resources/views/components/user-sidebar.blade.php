@props(['collapsed' => false])

<nav x-data="{ 
        open: false,
        isRtl: document.documentElement.dir === 'rtl',
    }" @toggle-sidebar.window="open = !open"
    class="w-64 bg-gradient-to-b from-white to-gray-50/50 border-e border-gray-200/60 h-screen flex flex-col fixed start-0 top-0 z-40 transition-all duration-300 lg:relative lg:translate-x-0 shadow-lg backdrop-blur-sm"
    x-bind:class="open ? 'translate-x-0' : (isRtl ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0')">

    
    <div class="flex items-center justify-between mb-8 pt-6 px-4">
        <div class="flex items-center gap-3 group">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 via-emerald-500 to-green-600 flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:shadow-xl group-hover:shadow-green-500/40 transition-all duration-300 group-hover:scale-105">
                <span class="text-white font-bold text-base">U</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900 tracking-tight">{{ __('user/profile.navigation.panel') }}
                </h1>
                <p class="text-xs text-gray-500 font-medium">{{ __('user/profile.navigation.dashboard') }}</p>
            </div>
        </div>
        <button @click="open = !open"
            class="lg:hidden text-gray-400 hover:text-gray-600 transition-all duration-200 p-2 rounded-lg hover:bg-gray-100 active:scale-95"
            aria-label="Toggle sidebar">
            <x-icon name="x" size="md" />
        </button>
    </div>

    
    <nav class="flex-1 overflow-y-auto px-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
        <ul class="space-y-1.5">
            
            <li>
                <a href="{{ route('user.profile.show') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-sm font-medium relative overflow-hidden cursor-pointer {{ request()->routeIs('user.profile.*') ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    @if(request()->routeIs('user.profile.*'))
                        <div
                            class="absolute start-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-green-500 via-emerald-500 to-green-600 rounded-e-full shadow-lg shadow-green-500/50">
                        </div>
                    @endif
                    <div
                        class="relative z-10 p-1.5 rounded-lg {{ request()->routeIs('user.profile.*') ? 'bg-green-100/50' : 'bg-gray-100/50 group-hover:bg-green-100/50' }} transition-all duration-300">
                        <x-icon name="user" size="md"
                            class="transition-all duration-300 {{ request()->routeIs('user.profile.*') ? 'text-green-600 scale-110' : 'text-gray-500 group-hover:text-green-600 group-hover:scale-110' }}" />
                    </div>
                    <span class="relative z-10 flex-1">{{ __('user/profile.navigation.profile') }}</span>
                </a>
            </li>

            
            <li>
                <a href="{{ route('user.profile.price-inquiries.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-sm font-medium relative overflow-hidden cursor-pointer {{ request()->routeIs('user.profile.price-inquiries.*') ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    @if(request()->routeIs('user.profile.price-inquiries.*'))
                        <div
                            class="absolute start-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-green-500 via-emerald-500 to-green-600 rounded-e-full shadow-lg shadow-green-500/50">
                        </div>
                    @endif
                    <div
                        class="relative z-10 p-1.5 rounded-lg {{ request()->routeIs('user.profile.price-inquiries.*') ? 'bg-green-100/50' : 'bg-gray-100/50 group-hover:bg-green-100/50' }} transition-all duration-300">
                        <x-icon name="dollar" size="md"
                            class="transition-all duration-300 {{ request()->routeIs('user.profile.price-inquiries.*') ? 'text-green-600 scale-110' : 'text-gray-500 group-hover:text-green-600 group-hover:scale-110' }}" />
                    </div>
                    <span class="relative z-10 flex-1">{{ __('user/profile.navigation.price_inquiries') }}</span>
                </a>
            </li>

            
            <li>
                <a href="{{ route('user.profile.orders.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-sm font-medium relative overflow-hidden cursor-pointer {{ request()->routeIs('user.profile.orders.*') ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    @if(request()->routeIs('user.profile.orders.*'))
                        <div
                            class="absolute start-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-green-500 via-emerald-500 to-green-600 rounded-e-full shadow-lg shadow-green-500/50">
                        </div>
                    @endif
                    <div
                        class="relative z-10 p-1.5 rounded-lg {{ request()->routeIs('user.profile.orders.*') ? 'bg-green-100/50' : 'bg-gray-100/50 group-hover:bg-green-100/50' }} transition-all duration-300">
                        <x-icon name="shopping-cart" size="md"
                            class="transition-all duration-300 {{ request()->routeIs('user.profile.orders.*') ? 'text-green-600 scale-110' : 'text-gray-500 group-hover:text-green-600 group-hover:scale-110' }}" />
                    </div>
                    <span class="relative z-10 flex-1">{{ __('user/profile.navigation.orders') }}</span>
                </a>
            </li>

            
            <li>
                <a href="{{ route('home') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-sm font-medium relative overflow-hidden cursor-pointer text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                    <div
                        class="relative z-10 p-1.5 rounded-lg bg-gray-100/50 group-hover:bg-green-100/50 transition-all duration-300">
                        <x-icon name="home" size="md"
                            class="transition-all duration-300 text-gray-500 group-hover:text-green-600 group-hover:scale-110" />
                    </div>
                    <span class="relative z-10 flex-1">{{ __('user/profile.navigation.home') }}</span>
                </a>
            </li>
        </ul>
    </nav>

    
    <div class="mt-auto pt-4 pb-4 px-4 border-t border-gray-200/60">
        <p class="text-xs text-center text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. {{ __('admin/components.copyright') }}
        </p>
    </div>
</nav>

<style>
    /* Custom scrollbar for sidebar */
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: rgb(209, 213, 219);
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgb(156, 163, 175);
    }
</style>