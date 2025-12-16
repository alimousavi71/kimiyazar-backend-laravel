<x-layouts.auth :title="__('auth.login.title')">
    <div class="w-full max-w-md" x-data="loginForm()">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600">
                <x-icon name="login" size="lg" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('auth.login.title') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('auth.login.welcome') }}</p>
            <p class="text-gray-600">{{ __('auth.login.subtitle') }}</p>
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

        <!-- Session Error -->
        @if (session('error'))
            <div class="mb-4">
                <x-alert type="danger" dismissible>
                    {{ session('error') }}
                </x-alert>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email or Phone -->
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

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        {{ __('auth.fields.password') }}
                    </label>
                    <a href="{{ route('auth.password.request') }}" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">
                        {{ __('auth.login.forgot_password') }}
                    </a>
                </div>
                <x-form-group :error="$errors->first('password')">
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            placeholder="{{ __('auth.placeholders.password') }}"
                            autocomplete="current-password"
                            x-ref="passwordInput"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                        />
                        <button
                            type="button"
                            @click="togglePasswordVisibility"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <x-icon x-show="!showPassword" name="eye" size="sm" />
                            <x-icon x-show="showPassword" name="eye-off" size="sm" />
                        </button>
                    </div>
                </x-form-group>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <x-toggle name="remember" :checked="old('remember')" class="h-5 w-9">
                    <span class="text-sm text-gray-700">{{ __('auth.login.remember_me') }}</span>
                </x-toggle>
            </div>

            <!-- Submit Button -->
            <div>
                <x-button type="submit" class="w-full">
                    {{ __('auth.login.submit') }}
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

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-gray-600">
                {{ __('auth.login.no_account') }}
                <a href="{{ route('auth.register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    {{ __('auth.login.register_link') }}
                </a>
            </p>
        </div>
    </div>

    <script>
        function loginForm() {
            return {
                showPassword: false,

                togglePasswordVisibility() {
                    this.showPassword = !this.showPassword;
                    this.$nextTick(() => {
                        this.$refs.passwordInput.focus();
                    });
                },
            };
        }
    </script>
</x-layouts.auth>