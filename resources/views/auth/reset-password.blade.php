@php
    $title = __('auth.password_requirements.title');
@endphp

<x-layouts.auth :title="$title">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden w-full max-w-md"
        x-data="passwordForm()">
        <!-- Header -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-400 px-6 py-8 text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm mb-4">
                <x-icon name="key" size="2xl" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">{{ __('auth.reset_password.title') }}</h1>
            <p class="text-green-100 text-sm">{{ __('auth.reset_password.subtitle') }}</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('auth.password.update') }}" class="p-6 space-y-5">
            @csrf

            <!-- Password -->
            <x-form-group :label="__('auth.fields.password')" required :error="$errors->first('password')">
                <div x-data="{ showPassword: false }" class="relative">
                    <input x-bind:type="showPassword ? 'text' : 'password'" name="password"
                        :placeholder="__('auth.placeholders.password')" required
                        class="w-full pe-10 px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 disabled:bg-gray-50 disabled:cursor-not-allowed bg-white shadow-sm hover:shadow-md focus:shadow-md"
                        @input="checkPasswordRequirements" x-ref="passwordInput" />
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute end-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                        aria-label="Toggle password visibility">
                        <x-icon name="hide" size="md" x-show="showPassword" />
                        <x-icon name="show-alt" size="md" x-show="!showPassword" />
                    </button>
                </div>
            </x-form-group>

            <!-- Password Confirmation -->
            <x-form-group :label="__('auth.fields.password_confirmation')" required
                :error="$errors->first('password_confirmation')">
                <div x-data="{ showPasswordConfirmation: false }" class="relative">
                    <input x-bind:type="showPasswordConfirmation ? 'text' : 'password'" name="password_confirmation"
                        :placeholder="__('auth.placeholders.password_confirmation')" required
                        class="w-full pe-10 px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 disabled:bg-gray-50 disabled:cursor-not-allowed bg-white shadow-sm hover:shadow-md focus:shadow-md"
                        x-ref="passwordConfirmationInput" />
                    <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation"
                        class="absolute end-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                        aria-label="Toggle password confirmation visibility">
                        <x-icon name="hide" size="md" x-show="showPasswordConfirmation" />
                        <x-icon name="show-alt" size="md" x-show="!showPasswordConfirmation" />
                    </button>
                </div>
            </x-form-group>

            <!-- Password Requirements -->
            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                <p class="text-sm font-semibold text-green-900 mb-3">{{ __('auth.password_requirements.title') }}</p>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-green-800">
                        <span class="w-2 h-2 rounded-full"
                            :class="passwordLength >= 8 ? 'bg-green-500' : 'bg-gray-300'"></span>
                        <span>{{ __('auth.password_requirements.min_length') }}</span>
                    </li>
                    <li class="flex items-center gap-2 text-sm text-green-800">
                        <span class="w-2 h-2 rounded-full" :class="hasLetter ? 'bg-green-500' : 'bg-gray-300'"></span>
                        <span>{{ __('auth.password_requirements.contains_letter') }}</span>
                    </li>
                    <li class="flex items-center gap-2 text-sm text-green-800">
                        <span class="w-2 h-2 rounded-full" :class="hasNumber ? 'bg-green-500' : 'bg-gray-300'"></span>
                        <span>{{ __('auth.password_requirements.contains_number') }}</span>
                    </li>
                </ul>
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

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" size="lg" class="w-full">
                <span class="flex items-center justify-center gap-2">
                    <x-icon name="check" size="md" />
                    {{ __('auth.reset_password.submit') }}
                </span>
            </x-button>

            <!-- Back to Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    <a href="{{ route('auth.login') }}"
                        class="font-semibold text-green-600 hover:text-green-700 transition-colors">
                        {{ __('auth.forgot_password.back_to_login') }}
                    </a>
                </p>
            </div>
        </form>
    </div>

    <script>
        function passwordForm() {
            return {
                showPassword: false,
                showPasswordConfirmation: false,
                passwordLength: 0,
                hasLetter: false,
                hasNumber: false,

                checkPasswordRequirements() {
                    const password = this.$refs.passwordInput.value;
                    this.passwordLength = password.length;
                    this.hasLetter = /[a-zA-Z]/.test(password);
                    this.hasNumber = /[0-9]/.test(password);
                },
            };
        }
    </script>
</x-layouts.auth>