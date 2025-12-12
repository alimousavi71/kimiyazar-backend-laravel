@props(['collapsed' => false])

<nav x-data="{ 
        open: false,
        isRtl: document.documentElement.dir === 'rtl',
        openGroups: {
            users: {{ request()->routeIs('admin.users.*') || request()->routeIs('users.*') ? 'true' : 'false' }},
            content: false,
            tools: {{ request()->routeIs('admin.examples.*') ? 'true' : 'false' }},
            auth: {{ request()->routeIs('login') || request()->routeIs('password.request') || request()->routeIs('two-factor.*') ? 'true' : 'false' }}
        }
    }" @toggle-sidebar.window="open = !open"
    class="w-64 bg-gradient-to-b from-white to-gray-50/50 border-e border-gray-200/60 h-screen flex flex-col fixed start-0 top-0 z-40 transition-all duration-300 lg:relative lg:translate-x-0 shadow-lg backdrop-blur-sm"
    x-bind:class="open ? 'translate-x-0' : (isRtl ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0')">

    <!-- Logo/Brand -->
    <div class="flex items-center justify-between mb-8 pt-6 px-4">
        <div class="flex items-center gap-3 group">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-xl group-hover:shadow-blue-500/40 transition-all duration-300 group-hover:scale-105">
                <span class="text-white font-bold text-base">A</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900 tracking-tight">Admin Panel</h1>
                <p class="text-xs text-gray-500 font-medium">Dashboard</p>
            </div>
        </div>
        <button @click="open = !open"
            class="lg:hidden text-gray-400 hover:text-gray-600 transition-all duration-200 p-2 rounded-lg hover:bg-gray-100 active:scale-95"
            aria-label="Toggle sidebar">
            <x-icon name="x" size="md" />
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto -mx-2 px-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
        <ul class="space-y-1.5">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') ?? route('dashboard') ?? '#' }}"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-sm font-medium relative overflow-hidden {{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm shadow-blue-100/50' : 'text-gray-700 hover:bg-gray-50/80 hover:text-gray-900' }}">
                    @if(request()->routeIs('admin.dashboard') || request()->routeIs('dashboard'))
                        <div
                            class="absolute start-0 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-e-full">
                        </div>
                    @endif
                    <x-icon name="home" size="md"
                        class="relative z-10 transition-transform duration-200 {{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') ? 'text-blue-600 scale-110' : 'text-gray-500 group-hover:text-blue-600 group-hover:scale-110' }}" />
                    <span
                        class="relative z-10">{{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') ? 'Dashboard' : 'Dashboard' }}</span>
                </a>
            </li>

            <!-- Users Group -->
            <li>
                <div x-data="{ open: openGroups.users }">
                    <button @click="open = !open; openGroups.users = open"
                        class="group w-full flex items-center justify-between gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 text-sm font-medium text-gray-700 hover:bg-gray-50/80 hover:text-gray-900 active:scale-[0.98]">
                        <div class="flex items-center gap-3">
                            <x-icon name="user" size="md"
                                class="text-gray-500 group-hover:text-blue-600 transition-colors duration-200" />
                            <span>Users</span>
                        </div>
                        <x-icon name="chevron-down" size="xs"
                            class="transition-all duration-300 text-gray-400 group-hover:text-gray-600"
                            x-bind:class="open ? 'rotate-180' : ''" />
                    </button>
                    <ul x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="mt-2 ms-3 space-y-1 border-s-2 border-gray-200/60 ps-4">
                        <li>
                            <a href="{{ route('admin.users.index') ?? route('users.index') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.users.index') || request()->routeIs('users.index') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="user-circle" size="sm"
                                    class="{{ request()->routeIs('admin.users.index') || request()->routeIs('users.index') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>All Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1">
                                <x-icon name="user-plus" size="sm"
                                    class="text-gray-400 group-hover:text-blue-600 transition-colors" />
                                <span>Add User</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1">
                                <x-icon name="group" size="sm"
                                    class="text-gray-400 group-hover:text-blue-600 transition-colors" />
                                <span>User Roles</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Content Group -->
            <li>
                <div x-data="{ open: openGroups.content }">
                    <button @click="open = !open; openGroups.content = open"
                        class="group w-full flex items-center justify-between gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 text-sm font-medium text-gray-700 hover:bg-gray-50/80 hover:text-gray-900 active:scale-[0.98]">
                        <div class="flex items-center gap-3">
                            <x-icon name="folder" size="md"
                                class="text-gray-500 group-hover:text-blue-600 transition-colors duration-200" />
                            <span>Content</span>
                        </div>
                        <x-icon name="chevron-down" size="xs"
                            class="transition-all duration-300 text-gray-400 group-hover:text-gray-600"
                            x-bind:class="open ? 'rotate-180' : ''" />
                    </button>
                    <ul x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="mt-2 ms-3 space-y-1 border-s-2 border-gray-200/60 ps-4">
                        <li>
                            <a href="#"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1">
                                <x-icon name="file" size="sm"
                                    class="text-gray-400 group-hover:text-blue-600 transition-colors" />
                                <span>Posts</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1">
                                <x-icon name="images" size="sm"
                                    class="text-gray-400 group-hover:text-blue-600 transition-colors" />
                                <span>Media</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1">
                                <x-icon name="category" size="sm"
                                    class="text-gray-400 group-hover:text-blue-600 transition-colors" />
                                <span>Categories</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Divider -->
            <li class="my-3">
                <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
            </li>

            <!-- Settings -->
            <li>
                <a href="{{ route('admin.settings') ?? route('settings') ?? '#' }}"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-sm font-medium relative overflow-hidden {{ request()->routeIs('admin.settings') || request()->routeIs('settings') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm shadow-blue-100/50' : 'text-gray-700 hover:bg-gray-50/80 hover:text-gray-900' }}">
                    @if(request()->routeIs('admin.settings') || request()->routeIs('settings'))
                        <div
                            class="absolute start-0 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-e-full">
                        </div>
                    @endif
                    <x-icon name="cog" size="md"
                        class="relative z-10 transition-all duration-200 {{ request()->routeIs('admin.settings') || request()->routeIs('settings') ? 'text-blue-600 scale-110' : 'text-gray-500 group-hover:text-blue-600 group-hover:scale-110' }}" />
                    <span class="relative z-10">Settings</span>
                </a>
            </li>

            <!-- Divider -->
            <li class="my-3">
                <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
            </li>

            <!-- Tools Group -->
            <li>
                <div x-data="{ open: openGroups.tools }">
                    <button @click="open = !open; openGroups.tools = open"
                        class="group w-full flex items-center justify-between gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 text-sm font-medium text-gray-700 hover:bg-gray-50/80 hover:text-gray-900 active:scale-[0.98]">
                        <div class="flex items-center gap-3">
                            <x-icon name="wrench" size="md"
                                class="text-gray-500 group-hover:text-blue-600 transition-colors duration-200" />
                            <span>Tools</span>
                        </div>
                        <x-icon name="chevron-down" size="xs"
                            class="transition-all duration-300 text-gray-400 group-hover:text-gray-600"
                            x-bind:class="open ? 'rotate-180' : ''" />
                    </button>
                    <ul x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="mt-2 ms-3 space-y-1 border-s-2 border-gray-200/60 ps-4">
                        <li>
                            <a href="{{ route('admin.examples.imask-test') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.examples.imask-test') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="code-alt" size="sm"
                                    class="{{ request()->routeIs('admin.examples.imask-test') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>IMask Test</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.examples.validation-example') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.examples.validation-example') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="check-circle" size="sm"
                                    class="{{ request()->routeIs('admin.examples.validation-example') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>Validation Example</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.examples.toast-example') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.examples.toast-example') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="notification" size="sm"
                                    class="{{ request()->routeIs('admin.examples.toast-example') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>Toast Examples</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.examples.axios-example') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.examples.axios-example') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="code-alt" size="sm"
                                    class="{{ request()->routeIs('admin.examples.axios-example') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>Axios Examples</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.examples.form-example') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.examples.form-example') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="edit" size="sm"
                                    class="{{ request()->routeIs('admin.examples.form-example') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>Form Example</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.examples.modal-example') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.examples.modal-example') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="folder" size="sm"
                                    class="{{ request()->routeIs('admin.examples.modal-example') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>Modal Example</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Divider -->
            <li class="my-3">
                <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
            </li>

            <!-- Authentication Pages -->
            <li>
                <div x-data="{ open: openGroups.auth }">
                    <button @click="open = !open; openGroups.auth = open"
                        class="group w-full flex items-center justify-between gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 text-sm font-medium text-gray-700 hover:bg-gray-50/80 hover:text-gray-900 active:scale-[0.98]">
                        <div class="flex items-center gap-3">
                            <x-icon name="lock" size="md"
                                class="text-gray-500 group-hover:text-blue-600 transition-colors duration-200" />
                            <span>Authentication</span>
                        </div>
                        <x-icon name="chevron-down" size="xs"
                            class="transition-all duration-300 text-gray-400 group-hover:text-gray-600"
                            x-bind:class="open ? 'rotate-180' : ''" />
                    </button>
                    <ul x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="mt-2 ms-3 space-y-1 border-s-2 border-gray-200/60 ps-4">
                        <li>
                            <a href="{{ route('login') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('login') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="log-in" size="sm"
                                    class="{{ request()->routeIs('login') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>Login</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('password.request') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('password.request') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="key" size="sm"
                                    class="{{ request()->routeIs('password.request') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>Forgot Password</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('two-factor.login') ?? '#' }}"
                                class="group flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('two-factor.*') ? 'bg-blue-50 text-blue-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900 hover:translate-x-1' }}">
                                <x-icon name="shield" size="sm"
                                    class="{{ request()->routeIs('two-factor.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors" />
                                <span>Two-Factor Auth</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

    <!-- User Profile Footer -->
    <div class="mt-auto pt-4 border-t border-gray-200/60">
        <div
            class="group flex items-center gap-3 px-3 py-3 rounded-xl bg-gradient-to-br from-gray-50 to-white hover:from-blue-50/50 hover:to-indigo-50/30 transition-all duration-300 cursor-pointer border border-gray-200/40 hover:border-blue-200/60 hover:shadow-md">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-blue-500/30 group-hover:shadow-xl group-hover:shadow-blue-500/40 group-hover:scale-105 transition-all duration-300 ring-2 ring-white/50">
                A
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-700 transition-colors">
                    Admin User</p>
                <p class="text-xs text-gray-500 truncate group-hover:text-gray-600 transition-colors">admin@example.com
                </p>
            </div>
            <x-icon name="chevron-right" size="sm"
                class="text-gray-400 group-hover:text-blue-600 transition-all duration-200 group-hover:translate-x-1" />
        </div>
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