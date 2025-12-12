@php
    $title = 'Login';
@endphp

<x-layouts.auth :title="$title">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 px-6 py-8 text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm mb-4">
                <x-icon name="lock" size="2xl" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">Welcome Back</h1>
            <p class="text-blue-100 text-sm">Sign in to your account to continue</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="p-6 space-y-5">
            @csrf

            <!-- Email -->
            <x-form-group label="Email Address" required error="{{ $errors->first('email') }}">
                <x-input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required
                    autofocus class="w-full" />
            </x-form-group>

            <!-- Password -->
            <x-form-group label="Password" required error="{{ $errors->first('password') }}">
                <div x-data="{ showPassword: false }" class="relative">
                    <input x-bind:type="showPassword ? 'text' : 'password'" name="password"
                        placeholder="Enter your password" required
                        class="w-full pe-10 px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 disabled:bg-gray-50 disabled:cursor-not-allowed bg-white shadow-sm hover:shadow-md focus:shadow-md" />
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute end-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                        aria-label="Toggle password visibility">
                        <x-icon name="hide" size="md" x-show="showPassword" />
                        <x-icon name="show-alt" size="md" x-show="!showPassword" />
                    </button>
                </div>
            </x-form-group>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                    <span class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                    Forgot password?
                </a>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <x-icon name="error-circle" size="md" class="text-red-600 mt-0.5 flex-shrink-0" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-900 mb-1">Authentication Error</p>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" size="lg" class="w-full">
                <span class="flex items-center justify-center gap-2">
                    <x-icon name="log-in" size="md" />
                    Sign In
                </span>
            </x-button>
        </form>
    </div>
</x-layouts.auth>