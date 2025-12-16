<x-layouts.auth :title="__('auth.register.title')">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-blue-500 to-purple-600">
                <x-icon name="user-add" size="lg" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('auth.register.title') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('auth.register.subtitle') }}</p>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="mb-4">
                @foreach ($errors->all() as $error)
                    <x-alert type="danger" dismissible>
                        {{ $error }}
                    </x-alert>
                @endforeach
            </div>
        @endif

        <!-- Success Alert -->
        @if (session('success'))
            <div class="mb-4">
                <x-alert type="success" dismissible>
                    {{ session('success') }}
                </x-alert>
            </div>
        @endif

        <!-- Registration Form -->
        <form action="{{ route('auth.register') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <x-form-group :label="__('auth.fields.email_or_phone')" :error="$errors->first('email_or_phone')" required>
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
            </div>

            <!-- Submit Button -->
            <div>
                <x-button type="submit" class="w-full">
                    {{ __('auth.register.submit') }}
                </x-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500"></span>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-gray-600">
                {{ __('auth.register.have_account') }}
                <a href="{{ route('auth.login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    {{ __('auth.register.login_link') }}
                </a>
            </p>
        </div>
</x-layouts.auth>
