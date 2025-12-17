@php
    $title = __('auth.forgot_password.title');
@endphp

<x-layouts.auth :title="$title">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden w-full max-w-md">
        <!-- Header -->
        <div class="bg-gradient-to-br from-amber-600 to-orange-600 px-6 py-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm mb-4">
                <x-icon name="key" size="2xl" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">{{ __('auth.forgot_password.title') }}</h1>
            <p class="text-amber-100 text-sm">{{ __('auth.forgot_password.subtitle') }}</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('auth.password.email') }}" class="p-6 space-y-5">
            @csrf

            <!-- Email or Phone -->
            <x-form-group :label="__('auth.fields.email_or_phone')" required :error="$errors->first('email_or_phone')">
                <x-input
                    type="text"
                    name="email_or_phone"
                    :placeholder="__('auth.placeholders.email_or_phone')"
                    value="{{ old('email_or_phone') }}"
                    autocomplete="off"
                    autofocus
                    class="w-full"
                />
            </x-form-group>

            <!-- Success Alert -->
            @if (session('success'))
                <x-alert type="success" dismissible>
                    {{ session('success') }}
                </x-alert>
            @endif

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

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" size="lg" class="w-full">
                <span class="flex items-center justify-center gap-2">
                    <x-icon name="send" size="md" />
                    {{ __('auth.forgot_password.submit') }}
                </span>
            </x-button>

            <!-- Back to Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    <a href="{{ route('auth.login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                        {{ __('auth.forgot_password.back_to_login') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-layouts.auth>
