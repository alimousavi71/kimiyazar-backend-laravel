<x-layouts.admin :title="__('admin/auth.two_factor.title')" :header-title="__('admin/auth.two_factor.title')"
    :breadcrumbs="[
        ['label' => __('admin/components.navigation.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/components.navigation.two_factor_auth')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/auth.two_factor.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/auth.two_factor.description') }}</p>
    </div>

    
    <x-session-messages :showInfo="true" />

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <x-card>
            <x-slot name="title">{{ __('admin/auth.two_factor.status_title') }}</x-slot>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg {{ $isEnabled ? 'bg-green-100' : 'bg-gray-100' }}">
                            <x-icon name="{{ $isEnabled ? 'check-circle' : 'x-circle' }}" size="md"
                                class="{{ $isEnabled ? 'text-green-600' : 'text-gray-400' }}" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ __('admin/auth.two_factor.status') }}
                            </p>
                            <p class="text-xs text-gray-600">
                                {{ $isEnabled ? __('admin/auth.two_factor.enabled') : __('admin/auth.two_factor.disabled') }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="px-3 py-1 rounded-full text-xs font-medium {{ $isEnabled ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $isEnabled ? __('admin/components.status.active') : __('admin/components.status.inactive') }}
                    </div>
                </div>

                <div class="flex gap-2">
                    @if($isEnabled)
                        <form method="POST" action="{{ route('admin.two-factor.disable') }}" class="flex-1"
                            onsubmit="return confirm('{{ __('admin/auth.two_factor.confirm_disable') }}');">
                            @csrf
                            <x-button type="submit" variant="danger" size="md" class="w-full">
                                <x-icon name="x-circle" size="sm" class="me-2" />
                                {{ __('admin/auth.two_factor.disable_button') }}
                            </x-button>
                        </form>
                    @else
                        <a href="{{ route('admin.two-factor.enable') }}" class="flex-1">
                            <x-button variant="primary" size="md" class="w-full">
                                <x-icon name="shield" size="sm" class="me-2" />
                                {{ __('admin/auth.two_factor.enable_button') }}
                            </x-button>
                        </a>
                    @endif
                </div>
            </div>
        </x-card>

        
        @if($isEnabled)
            <x-card>
                <x-slot name="title">{{ __('admin/auth.two_factor.recovery_codes_title') }}</x-slot>

                <div class="space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <x-icon name="info-circle" size="md" class="text-blue-600 mt-0.5 flex-shrink-0" />
                            <div class="flex-1">
                                <p class="text-sm font-medium text-blue-900 mb-1">
                                    {{ __('admin/auth.two_factor.recovery_codes_info_title') }}
                                </p>
                                <p class="text-xs text-blue-700">
                                    {{ __('admin/auth.two_factor.recovery_codes_info') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if(session('recoveryCodes'))
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <p class="text-sm font-medium text-gray-900 mb-3">
                                {{ __('admin/auth.two_factor.save_codes') }}
                            </p>
                            <div class="grid grid-cols-2 gap-2 font-mono text-sm">
                                @foreach(session('recoveryCodes') as $code)
                                    <div class="p-2 bg-white rounded-lg border border-gray-200 text-center">
                                        {{ $code }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.two-factor.recovery-codes.regenerate') }}"
                        onsubmit="return confirm('{{ __('admin/auth.two_factor.confirm_regenerate') }}');">
                        @csrf
                        <x-button type="submit" variant="secondary" size="md" class="w-full">
                            <x-icon name="refresh" size="sm" class="me-2" />
                            {{ __('admin/auth.two_factor.regenerate_codes') }}
                        </x-button>
                    </form>
                </div>
            </x-card>
        @endif
    </div>
</x-layouts.admin>