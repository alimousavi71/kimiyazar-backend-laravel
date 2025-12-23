<x-layouts.user-profile :title="__('user/profile/email.forms.edit.title')"
    :header-title="__('user/profile/email.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile.breadcrumbs.profile'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile/email.forms.edit.title')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('user/profile/email.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('user/profile/email.forms.edit.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('user/profile/email.forms.edit.card_title') }}</x-slot>

        <div class="space-y-4 mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <x-icon name="info-circle" size="md" class="text-blue-600 mt-0.5" />
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">{{ __('user/profile/email.forms.edit.current_email') }}</p>
                        <p class="text-blue-900">{{ $user->email ?? __('user/profile/email.forms.edit.no_email') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <form id="email-edit-form" action="{{ route('user.profile.email.send-otp') }}" method="POST" class="space-y-6">
            @csrf

            <x-form-group :label="__('user/profile/email.forms.edit.new_email')" required
                :error="$errors->first('email')">
                <x-input type="email" name="email" id="email"
                    :placeholder="__('user/profile/email.forms.edit.placeholder_email')" value="{{ old('email') }}"
                    required class="w-full" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('user.profile.show') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('user/profile/email.forms.edit.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.user-profile>