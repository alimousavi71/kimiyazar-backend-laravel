@php
    $title = __('user/profile/email.verify.title');
@endphp

<x-layouts.user-profile :title="$title" :header-title="__('user/profile/email.verify.header_title')" :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile.breadcrumbs.profile'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile/email.verify.title')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('user/profile/email.verify.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('user/profile/email.verify.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('user/profile/email.verify.card_title') }}</x-slot>

        <div class="space-y-4 mb-6">
            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                <div class="text-sm text-green-800">
                    <p class="font-semibold mb-1">{{ __('user/profile/email.verify.sent_to') }}</p>
                    <p class="text-green-900">{{ Str::mask($new_email, '*', 3, -3) }}</p>
                </div>
            </div>
        </div>

        <form id="email-verify-form" action="{{ route('user.profile.email.verify') }}" method="POST" class="space-y-6"
            x-data="otpVerification()" x-init="startCountdown()">
            @csrf

            <x-form-group :label="__('user/profile/email.verify.code_label')" required :error="$errors->first('code')">
                <x-input type="text" name="code" id="code" maxlength="5" inputmode="numeric" placeholder="12345"
                    value="{{ old('code') }}" required class="w-full text-center text-2xl tracking-widest"
                    x-ref="codeInput" @input="handleCodeInput" />
            </x-form-group>

            <!-- Success/Error Messages -->
            <x-session-messages />

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('user.profile.email.edit') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('user/profile/email.verify.submit') }}
                </x-button>
            </div>
        </form>

        <!-- Resend OTP Section -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="text-center space-y-3">
                <div x-show="countdown > 0" class="text-sm text-gray-600">
                    <span
                        x-text="`{{ __('user/profile/email.verify.resend_timer') }}`.replace(':seconds', countdown)"></span>
                </div>
                <form action="{{ route('user.profile.email.resend-otp') }}" method="POST" x-show="countdown === 0">
                    @csrf
                    <x-button variant="secondary" type="submit" class="w-full" :disabled="isResending">
                        <span x-show="!isResending" class="flex items-center justify-center gap-2">
                            <x-icon name="send" size="sm" />
                            {{ __('user/profile/email.verify.resend') }}
                        </span>
                        <span x-show="isResending" class="flex items-center justify-center gap-2">
                            <x-icon name="loader" size="sm" class="animate-spin" />
                            {{ __('user/profile/email.verify.sending') }}
                        </span>
                    </x-button>
                </form>
            </div>
        </div>
    </x-card>

    @push('scripts')
        <script>
            function otpVerification() {
                return {
                    countdown: 60,
                    isResending: false,
                    startCountdown() {
                        const interval = setInterval(() => {
                            if (this.countdown > 0) {
                                this.countdown--;
                            } else {
                                clearInterval(interval);
                            }
                        }, 1000);
                    },
                    handleCodeInput(event) {
                        let value = event.target.value.replace(/\D/g, '').slice(0, 5);
                        event.target.value = value;
                    }
                }
            }
        </script>
    @endpush
</x-layouts.user-profile>