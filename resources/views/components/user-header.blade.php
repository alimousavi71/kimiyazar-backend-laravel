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
                <!-- User Menu -->
                @php
                    $user = auth()->user();
                    $userName = $user ? $user->getFullName() : 'User';
                    $userEmail = $user ? $user->email : 'user@example.com';
                    $userInitials = $user ? mb_substr($user->first_name ?? '', 0, 1, 'UTF-8') . mb_substr($user->last_name ?? '', 0, 1, 'UTF-8') : 'U';
                @endphp
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors p-1.5 rounded-xl hover:bg-gray-100"
                        aria-label="{{ __('user/profile.header.user_menu') }}">
                        <div
                            class="w-8 h-8 rounded-xl bg-gradient-to-br from-green-500 to-emerald-400 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                            {{ $userInitials }}
                        </div>
                        <x-icon name="chevron-down" size="sm" class="hidden sm:block" />
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition x-cloak
                        class="absolute end-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 py-1.5 z-50 overflow-hidden"
                        style="display: none;">
                        <!-- User Info Header -->
                        <div
                            class="px-4 py-3 border-b border-gray-100 bg-linear-to-br from-green-50/50 to-emerald-50/50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-linear-to-br from-green-500 to-emerald-400 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                                    {{ $userInitials }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $userName }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $userEmail }}</p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('user.profile.show') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <x-icon name="user" size="md" />
                            <span>{{ __('user/profile.header.profile') }}</span>
                        </a>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="{{ route('auth.logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-start">
                                <x-icon name="log-out" size="md" />
                                <span>{{ __('user/profile.header.logout') }}</span>
                            </button>
                        </form>
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