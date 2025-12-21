@php
    $title = __('auth.login.title');
@endphp

<x-layouts.auth :title="$title">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden w-full max-w-md">
        <!-- Header -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-400 px-6 py-8 text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm mb-4">
                <x-icon name="lock" size="2xl" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">{{ __('auth.login.welcome') }}</h1>
            <p class="text-green-100 text-sm">{{ __('auth.login.subtitle') }}</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('auth.login') }}" class="p-6 space-y-5">
            @csrf

            <!-- Email or Phone -->
            <x-form-group :label="__('auth.fields.email_or_phone')" required :error="$errors->first('email_or_phone')">
                <x-input type="text" name="email_or_phone" :placeholder="__('auth.placeholders.email_or_phone')"
                    value="{{ old('email_or_phone') }}" autocomplete="off" autofocus class="w-full" />
            </x-form-group>

            <!-- Password -->
            <x-form-group :label="__('auth.fields.password')" required :error="$errors->first('password')">
                <div x-data="{ showPassword: false }" class="relative">
                    <input x-bind:type="showPassword ? 'text' : 'password'" name="password"
                        :placeholder="__('auth.placeholders.password')" required
                        class="w-full pe-10 px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 disabled:bg-gray-50 disabled:cursor-not-allowed bg-white shadow-sm hover:shadow-md focus:shadow-md" />
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
                        class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-0 cursor-pointer">
                    <span
                        class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors">{{ __('auth.login.remember_me') }}</span>
                </label>
                <a href="{{ route('auth.password.request') }}"
                    class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors">
                    {{ __('auth.login.forgot_password') }}
                </a>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <x-alert type="danger" dismissible>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <!-- Session Error -->
            @if(session('error'))
                <x-alert type="danger" dismissible>
                    {{ session('error') }}
                </x-alert>
            @endif

            <!-- Success Message -->
            @if(session('success'))
                <x-alert type="success" dismissible>
                    {{ session('success') }}
                </x-alert>
            @endif

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" size="lg" class="w-full">
                <span class="flex items-center justify-center gap-2">
                    <x-icon name="log-in" size="md" />
                    {{ __('auth.login.submit') }}
                </span>
            </x-button>

            <!-- Register Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    {{ __('auth.login.no_account') }}
                    <a href="{{ route('auth.register') }}"
                        class="font-semibold text-green-600 hover:text-green-700 transition-colors">
                        {{ __('auth.login.register_link') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-layouts.auth>