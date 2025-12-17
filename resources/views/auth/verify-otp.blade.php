@php
    $title = __('auth.verify_otp.title');
@endphp

<x-layouts.auth :title="$title">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden w-full max-w-md" x-data="otpVerification()" x-init="startCountdown()">
        <!-- Header -->
        <div class="bg-gradient-to-br from-green-600 to-teal-600 px-6 py-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm mb-4">
                <x-icon name="shield-check" size="2xl" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">{{ __('auth.verify_otp.title') }}</h1>
            <p class="text-green-100 text-sm">
                @if ($type === 'email')
                    {{ __('auth.verify_otp.subtitle_email') }}
                @else
                    {{ __('auth.verify_otp.subtitle_sms') }}
                @endif
            </p>
        </div>

        <!-- Form -->
        <form method="POST" :action="$step === 'registration' ? '{{ route('auth.register.verify-otp') }}' : '{{ route('auth.password.verify-otp') }}'" class="p-6 space-y-5">
            @csrf

            <!-- Contact Display -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <span>{{ __('auth.verify_otp.sent_to') }}:</span>
                        <span class="font-semibold text-gray-900">{{ Str::mask($email_or_phone, '*', 3, -3) }}</span>
                    </div>
                    @if (isset($step) && $step === 'registration')
                        <a href="{{ route('auth.register') }}" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">
                            {{ __('auth.verify_otp.back_to_register') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- OTP Code Input -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('auth.verify_otp.code_label') }}
                </label>
                <input
                    type="text"
                    id="code"
                    name="code"
                    maxlength="6"
                    inputmode="numeric"
                    placeholder="000000"
                    value="{{ old('code') }}"
                    class="w-full px-4 py-3 text-center text-2xl tracking-widest rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('code') border-red-500 @enderror"
                    autofocus
                    x-ref="codeInput"
                    @input="handleCodeInput"
                />
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Error Messages -->
            @if($errors->any() && !$errors->first('code'))
                <x-alert type="danger" dismissible>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            @if($error !== $errors->first('code'))
                                <li>{{ $error }}</li>
                            @endif
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" size="lg" class="w-full">
                <span class="flex items-center justify-center gap-2">
                    <x-icon name="check" size="md" />
                    {{ __('auth.verify_otp.submit') }}
                </span>
            </x-button>
        </form>

        <!-- Resend OTP Section -->
        <div class="px-6 pb-6">
            <div class="text-center space-y-3">
                <div x-show="countdown > 0" class="text-sm text-gray-600">
                    <span x-text="`{{ __('auth.verify_otp.resend_timer') }}`.replace(':seconds', countdown)"></span>
                </div>
                <button
                    type="button"
                    x-show="countdown === 0"
                    @click="resendOtp"
                    :disabled="isResending"
                    class="w-full py-2.5 px-4 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-50 disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-colors"
                >
                    <span x-show="!isResending" class="flex items-center justify-center gap-2">
                        <x-icon name="send" size="md" />
                        {{ __('auth.verify_otp.resend') }}
                    </span>
                    <span x-show="isResending" class="flex items-center justify-center gap-2">
                        <x-icon name="loader" size="md" class="animate-spin" />
                        {{ __('auth.messages.sending') ?? 'درحال ارسال...' }}
                    </span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function otpVerification() {
            return {
                countdown: 120,
                isResending: false,
                otpId: {{ session(isset($step) ? $step . '.otp_id' : 'password_reset.otp_id') ?? 'null' }},
                step: '{{ isset($step) ? $step : 'password_reset' }}',

                startCountdown() {
                    if (this.countdown > 0) {
                        const interval = setInterval(() => {
                            this.countdown--;
                            if (this.countdown <= 0) {
                                clearInterval(interval);
                            }
                        }, 1000);
                    }
                },

                handleCodeInput(event) {
                    const input = event.target;
                    input.value = input.value.replace(/[^\d]/g, '');

                    if (input.value.length === 6) {
                        setTimeout(() => {
                            input.form.submit();
                        }, 100);
                    }
                },

                async resendOtp() {
                    if (!this.otpId || this.isResending) return;

                    this.isResending = true;

                    try {
                        const route = this.step === 'registration'
                            ? '{{ route("auth.register.resend-otp") }}'
                            : '{{ route("auth.password.resend-otp") }}';

                        const response = await fetch(route, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-Token': document.querySelector('[name=_token]').value,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                otp_id: this.otpId,
                            }),
                        });

                        if (response.ok) {
                            const data = await response.json();
                            if (data.success) {
                                this.$dispatch('notify', {
                                    type: 'success',
                                    message: '{{ __("auth.messages.otp_resent") }}',
                                });
                                this.countdown = 120;
                                this.startCountdown();
                                this.$refs.codeInput.value = '';
                                this.$refs.codeInput.focus();
                                if (data.data?.otp_id) {
                                    this.otpId = data.data.otp_id;
                                }
                            }
                        } else {
                            this.$dispatch('notify', {
                                type: 'error',
                                message: '{{ __("auth.messages.otp_failed") ?? "خطا در ارسال کد" }}',
                            });
                        }
                    } catch (error) {
                        console.error('Resend error:', error);
                        this.$dispatch('notify', {
                            type: 'error',
                            message: '{{ __("auth.messages.network_error") ?? "خطا در ارتباط" }}',
                        });
                    } finally {
                        this.isResending = false;
                    }
                },
            };
        }
    </script>
</x-layouts.auth>
