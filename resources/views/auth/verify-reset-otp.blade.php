<x-layouts.auth :title="__('auth.verify_otp.title')">
    <div class="w-full max-w-md" x-data="otpVerification()" x-init="startCountdown()">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-green-500 to-teal-600">
                <x-icon name="shield-check" size="lg" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('auth.verify_otp.title') }}</h1>
            <p class="mt-2 text-gray-600">
                @if ($type === 'email')
                    {{ __('auth.verify_otp.subtitle_email') }}
                @else
                    {{ __('auth.verify_otp.subtitle_sms') }}
                @endif
            </p>
        </div>

        <!-- Contact Display -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <span>{{ __('auth.verify_otp.sent_to') }}:</span>
                    <span class="font-semibold text-gray-900 mr-2">{{ Str::mask($email_or_phone, '*', 3, -3) }}</span>
                </div>
            </div>
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

        <!-- OTP Verification Form -->
        <form action="{{ route('auth.password.verify-otp') }}" method="POST" class="space-y-6">
            @csrf

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
                    class="w-full px-4 py-3 text-center text-2xl tracking-widest border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                    autofocus
                    x-ref="codeInput"
                    @input="handleCodeInput"
                />
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <x-button type="submit" class="w-full">
                    {{ __('auth.verify_otp.submit') }}
                </x-button>
            </div>
        </form>

        <!-- Resend OTP Section -->
        <div class="mt-8 space-y-4">
            <div class="text-center">
                <span
                    x-show="countdown > 0"
                    class="text-sm text-gray-600"
                    x-text="`{{ __('auth.verify_otp.resend_timer') }}`.replace(':seconds', countdown)"
                ></span>
                <button
                    type="button"
                    x-show="countdown === 0"
                    @click="resendOtp"
                    :disabled="isResending"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-700 disabled:text-gray-400 disabled:cursor-not-allowed transition-colors"
                >
                    <span x-show="!isResending">{{ __('auth.verify_otp.resend') }}</span>
                    <span x-show="isResending" class="inline-flex items-center gap-2">
                        <x-icon name="loader" size="sm" class="animate-spin" />
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
                otpId: {{ session('password_reset.otp_id') ?? 'null' }},

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
                    // Remove non-digit characters
                    input.value = input.value.replace(/[^\d]/g, '');

                    // Auto-submit when 6 digits are entered
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
                        const response = await fetch(
                            '{{ route("auth.password.resend-otp") }}',
                            {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-Token': document.querySelector('[name=_token]').value,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    otp_id: this.otpId,
                                }),
                            }
                        );

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
                                // Update OTP ID if a new one was issued
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
@endsection
