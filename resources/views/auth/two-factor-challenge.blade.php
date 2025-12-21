@php
    $title = __('admin/auth.two_factor_challenge.title');
@endphp

<x-layouts.auth :title="$title">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-br from-purple-600 to-pink-600 px-6 py-8 text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm mb-4">
                <x-icon name="shield" size="2xl" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">{{ __('admin/auth.two_factor_challenge.title') }}</h1>
            <p class="text-purple-100 text-sm">{{ __('admin/auth.two_factor_challenge.subtitle') }}</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.two-factor.verify') }}" class="p-6 space-y-5" x-data="{ 
                code: ['', '', '', '', '', ''],
                handleInput(index, event) {
                    const value = event.target.value.replace(/[^0-9]/g, '');
                    if (value) {
                        this.code[index] = value.slice(-1);
                        if (index < 5) {
                            setTimeout(() => {
                                const nextInput = document.querySelector(`[data-index='${index + 1}']`);
                                if (nextInput) nextInput.focus();
                            }, 10);
                        }
                    } else {
                        this.code[index] = '';
                    }
                    this.updateHiddenInput();
                },
                handleKeyDown(index, event) {
                    if (event.key === 'Backspace' && !this.code[index] && index > 0) {
                        setTimeout(() => {
                            const prevInput = document.querySelector(`[data-index='${index - 1}']`);
                            if (prevInput) prevInput.focus();
                        }, 10);
                    } else if (event.key === 'ArrowLeft' && index > 0) {
                        setTimeout(() => {
                            const prevInput = document.querySelector(`[data-index='${index - 1}']`);
                            if (prevInput) prevInput.focus();
                        }, 10);
                    } else if (event.key === 'ArrowRight' && index < 5) {
                        setTimeout(() => {
                            const nextInput = document.querySelector(`[data-index='${index + 1}']`);
                            if (nextInput) nextInput.focus();
                        }, 10);
                    }
                },
                updateHiddenInput() {
                    const hiddenInput = document.getElementById('code-input');
                    if (hiddenInput) {
                        hiddenInput.value = this.code.join('');
                    }
                }
            }">
            @csrf

            <!-- 2FA Code Input -->
            <div>
                <label class="text-sm font-medium text-gray-700 mb-3 block">
                    {{ __('admin/auth.two_factor_challenge.verification_code') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center justify-center gap-2 mb-2">
                    @for($i = 0; $i < 6; $i++)
                        <input type="text" maxlength="1" pattern="[0-9]" x-model="code[{{ $i }}]"
                            @input="handleInput({{ $i }}, $event)" @keydown="handleKeyDown({{ $i }}, $event)"
                            data-index="{{ $i }}"
                            class="w-12 h-14 text-center text-2xl font-semibold rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all duration-200 bg-white shadow-sm"
                            autocomplete="off" inputmode="numeric" />
                    @endfor
                </div>
                <p class="text-xs text-gray-500 text-center mt-2">
                    {{ __('admin/auth.two_factor_challenge.enter_code_help') }}
                </p>
            </div>

            <!-- Recovery Code Option -->
            <div class="pt-2">
                <details class="group">
                    <summary
                        class="cursor-pointer text-sm text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-2">
                        <x-icon name="help-circle" size="sm" />
                        <span>{{ __('admin/auth.two_factor_challenge.use_recovery_code') }}</span>
                        <x-icon name="chevron-down" size="xs"
                            class="ms-auto transition-transform group-open:rotate-180" />
                    </summary>
                    <div class="mt-3 space-y-3">
                        <x-form-group :label="__('admin/auth.two_factor_challenge.recovery_code')"
                            error="{{ $errors->first('recovery_code') }}">
                            <x-input type="text" name="recovery_code"
                                :placeholder="__('admin/auth.two_factor_challenge.recovery_code_placeholder')"
                                class="w-full" />
                        </x-form-group>
                    </div>
                </details>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <x-icon name="error-circle" size="md" class="text-red-600 mt-0.5 shrink-0" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-900 mb-1">
                                {{ __('admin/auth.two_factor_challenge.verification_error') }}
                            </p>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Hidden input for the full code -->
            <input type="hidden" name="code" id="code-input" x-bind:value="code.join('')" />

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" size="lg" class="w-full">
                <span class="flex items-center justify-center gap-2">
                    <x-icon name="check-circle" size="md" />
                    {{ __('admin/auth.two_factor_challenge.verify_button') }}
                </span>
            </x-button>

            <!-- Help Text -->
            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <x-icon name="info-circle" size="md" class="text-green-600 mt-0.5 shrink-0" />
                    <div class="flex-1">
                        <p class="text-sm font-medium text-green-900 mb-1">
                            {{ __('admin/auth.two_factor_challenge.need_help_title') }}
                        </p>
                        <p class="text-xs text-green-700">
                            {{ __('admin/auth.two_factor_challenge.need_help_text') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back to Login -->
            <div class="text-center pt-2">
                <a href="{{ route('admin.login') }}"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors inline-flex items-center gap-1">
                    <x-icon name="arrow-back" size="sm" />
                    {{ __('admin/auth.two_factor_challenge.back_to_login') }}
                </a>
            </div>
        </form>
    </div>

    <script>
        // Auto-focus first input on load
        document.addEventListener('DOMContentLoaded', function () {
            const firstInput = document.querySelector('[data-index="0"]');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
        });
    </script>
</x-layouts.auth>