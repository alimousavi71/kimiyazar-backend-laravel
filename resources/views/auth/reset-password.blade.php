@extends('components.layouts.auth')

@section('content')
    <div class="w-full max-w-md" x-data="passwordForm()">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-green-500 to-emerald-600">
                <x-icon name="lock-reset" size="lg" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('auth.reset_password.title') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('auth.reset_password.subtitle') }}</p>
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

        <!-- Reset Password Form -->
        <form action="{{ route('auth.password.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Password -->
            <div>
                <x-form-group :label="__('auth.fields.password')" :error="$errors->first('password')" required>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            placeholder="{{ __('auth.placeholders.password') }}"
                            autocomplete="new-password"
                            x-ref="passwordInput"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                            @input="checkPasswordRequirements"
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

            <!-- Password Confirmation -->
            <div>
                <x-form-group :label="__('auth.fields.password_confirmation')" :error="$errors->first('password_confirmation')" required>
                    <div class="relative">
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="{{ __('auth.placeholders.password_confirmation') }}"
                            autocomplete="new-password"
                            x-ref="passwordConfirmationInput"
                            x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                            class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                        />
                        <button
                            type="button"
                            @click="togglePasswordConfirmationVisibility"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <x-icon x-show="!showPasswordConfirmation" name="eye" size="sm" />
                            <x-icon x-show="showPasswordConfirmation" name="eye-off" size="sm" />
                        </button>
                    </div>
                </x-form-group>
            </div>

            <!-- Password Requirements -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm font-semibold text-blue-900 mb-3">{{ __('auth.password_requirements.title') }}</p>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-blue-800">
                        <span class="w-2 h-2 rounded-full" :class="passwordLength >= 8 ? 'bg-green-500' : 'bg-gray-300'"></span>
                        <span>{{ __('auth.password_requirements.min_length') }}</span>
                    </li>
                    <li class="flex items-center gap-2 text-sm text-blue-800">
                        <span class="w-2 h-2 rounded-full" :class="hasLetter ? 'bg-green-500' : 'bg-gray-300'"></span>
                        <span>{{ __('auth.password_requirements.contains_letter') }}</span>
                    </li>
                    <li class="flex items-center gap-2 text-sm text-blue-800">
                        <span class="w-2 h-2 rounded-full" :class="hasNumber ? 'bg-green-500' : 'bg-gray-300'"></span>
                        <span>{{ __('auth.password_requirements.contains_number') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Submit Button -->
            <div>
                <x-button type="submit" class="w-full">
                    {{ __('auth.reset_password.submit') }}
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

        <!-- Back to Login Link -->
        <div class="text-center">
            <a href="{{ route('auth.login') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                {{ __('auth.reset_password.back_to_login') }}
            </a>
        </div>
    </div>

    <script>
        function passwordForm() {
            return {
                showPassword: false,
                showPasswordConfirmation: false,
                passwordLength: 0,
                hasLetter: false,
                hasNumber: false,

                togglePasswordVisibility() {
                    this.showPassword = !this.showPassword;
                },

                togglePasswordConfirmationVisibility() {
                    this.showPasswordConfirmation = !this.showPasswordConfirmation;
                },

                checkPasswordRequirements() {
                    const password = this.$refs.passwordInput.value;
                    this.passwordLength = password.length;
                    this.hasLetter = /[a-zA-Z]/.test(password);
                    this.hasNumber = /[0-9]/.test(password);
                },

                init() {
                    this.$refs.passwordInput.addEventListener('input', () => {
                        this.checkPasswordRequirements();
                    });
                },
            };
        }
    </script>
@endsection
