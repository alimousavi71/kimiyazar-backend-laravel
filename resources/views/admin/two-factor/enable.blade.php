<x-layouts.admin :title="__('admin/auth.two_factor.enable_title')"
    :header-title="__('admin/auth.two_factor.enable_title')" :breadcrumbs="[
        ['label' => __('admin/components.navigation.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/components.navigation.two_factor_auth'), 'url' => route('admin.two-factor.status')],
        ['label' => __('admin/auth.two_factor.enable_title')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/auth.two_factor.enable_title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/auth.two_factor.enable_description') }}</p>
    </div>

    
    @if($errors->any())
        <x-alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <x-card>
            <x-slot name="title">{{ __('admin/auth.two_factor.scan_qr_title') }}</x-slot>

            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <x-icon name="info-circle" size="md" class="text-blue-600 mt-0.5 flex-shrink-0" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-900 mb-1">
                                {{ __('admin/auth.two_factor.scan_instructions_title') }}
                            </p>
                            <ol class="text-xs text-blue-700 space-y-1 list-decimal list-inside">
                                <li>{{ __('admin/auth.two_factor.scan_step1') }}</li>
                                <li>{{ __('admin/auth.two_factor.scan_step2') }}</li>
                                <li>{{ __('admin/auth.two_factor.scan_step3') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center p-6 bg-white rounded-xl border-2 border-dashed border-gray-200">
                    <div class="text-center">
                        {!! $qrCode !!}
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                    <p class="text-xs font-medium text-gray-700 mb-2">
                        {{ __('admin/auth.two_factor.secret_key') }}
                    </p>
                    <div class="flex items-center gap-2">
                        <code
                            class="flex-1 p-2 bg-white rounded-lg border border-gray-200 text-sm font-mono text-center">
                            {{ $secret }}
                        </code>
                        <button type="button" onclick="copySecret()"
                            class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                            title="{{ __('admin/auth.two_factor.copy_secret') }}">
                            <x-icon name="copy" size="sm" />
                        </button>
                    </div>
                </div>
            </div>
        </x-card>

        
        <x-card>
            <x-slot name="title">{{ __('admin/auth.two_factor.verify_title') }}</x-slot>

            <form method="POST" action="{{ route('admin.two-factor.enable.store') }}" class="space-y-4">
                @csrf

                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <x-icon name="alert-triangle" size="md" class="text-yellow-600 mt-0.5 flex-shrink-0" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-yellow-900 mb-1">
                                {{ __('admin/auth.two_factor.verify_warning_title') }}
                            </p>
                            <p class="text-xs text-yellow-700">
                                {{ __('admin/auth.two_factor.verify_warning') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        {{ __('admin/auth.two_factor.verification_code') }}
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center justify-center gap-2 mb-2">
                        @for($i = 0; $i < 6; $i++)
                            <input type="text" maxlength="1" pattern="[0-9]" data-index="{{ $i }}"
                                class="w-12 h-14 text-center text-2xl font-semibold rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-200 bg-white shadow-sm"
                                autocomplete="off" inputmode="numeric" />
                        @endfor
                    </div>
                    <input type="hidden" name="code" id="code-input" />
                    <p class="text-xs text-gray-500 text-center mt-2">
                        {{ __('admin/auth.two_factor.enter_code_help') }}
                    </p>
                </div>

                <x-button type="submit" variant="primary" size="lg" class="w-full">
                    <x-icon name="check-circle" size="sm" class="me-2" />
                    {{ __('admin/auth.two_factor.enable_button') }}
                </x-button>

                <a href="{{ route('admin.two-factor.status') }}" class="block text-center">
                    <x-button type="button" variant="secondary" size="md" class="w-full">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
            </form>
        </x-card>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const code = ['', '', '', '', '', ''];

                function handleInput(index, event) {
                    const value = event.target.value.replace(/[^0-9]/g, '');
                    if (value) {
                        code[index] = value.slice(-1);
                        if (index < 5) {
                            setTimeout(() => {
                                const nextInput = document.querySelector(`[data-index='${index + 1}']`);
                                if (nextInput) nextInput.focus();
                            }, 10);
                        }
                    } else {
                        code[index] = '';
                    }
                    updateHiddenInput();
                }

                function handleKeyDown(index, event) {
                    if (event.key === 'Backspace' && !code[index] && index > 0) {
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
                }

                function updateHiddenInput() {
                    const hiddenInput = document.getElementById('code-input');
                    if (hiddenInput) {
                        hiddenInput.value = code.join('');
                    }
                }

                // Attach event listeners
                for (let i = 0; i < 6; i++) {
                    const input = document.querySelector(`[data-index='${i}']`);
                    if (input) {
                        input.addEventListener('input', (e) => handleInput(i, e));
                        input.addEventListener('keydown', (e) => handleKeyDown(i, e));
                    }
                }

                // Auto-focus first input
                const firstInput = document.querySelector('[data-index="0"]');
                if (firstInput) {
                    setTimeout(() => firstInput.focus(), 100);
                }
            });

            function copySecret() {
                const secret = '{{ $secret }}';
                navigator.clipboard.writeText(secret).then(() => {
                    // Show toast notification
                    if (window.showToast) {
                        showToast('{{ __('admin/auth.two_factor.secret_copied') }}', 'success');
                    }
                });
            }
        </script>
    @endpush
</x-layouts.admin>