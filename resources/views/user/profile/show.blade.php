<x-layouts.user-profile :title="__('user/profile.show.title')" :header-title="__('user/profile.show.header_title')"
    :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/profile.breadcrumbs.profile')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('user/profile.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('user/profile.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('user.profile.edit') }}">
                <x-button variant="primary" size="md">
                    {{ __('user/profile.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('user.profile.password.edit') }}">
                <x-button variant="secondary" size="md">
                    {{ __('user/profile.forms.password.title') }}
                </x-button>
            </a>
        </div>
    </div>

    
    <x-session-messages />

    <div class="space-y-6">
        <x-card>
            <x-slot name="title">{{ __('user/profile.show.personal_info') }}</x-slot>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/profile.fields.first_name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->first_name }}</p>
                    </div>
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/profile.fields.last_name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->last_name }}</p>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('user/profile.fields.full_name') }}</label>
                    <p class="text-base text-gray-900 mt-1">{{ $user->getFullName() }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('user/profile.fields.email') }}</label>
                    <p class="text-base text-gray-900 mt-1">{{ $user->email }}</p>
                </div>

                @if($user->phone_number)
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/profile.fields.phone_number') }}</label>
                        <p class="text-base text-gray-900 mt-1">
                            {{ $user->getFullPhoneNumber() ?? $user->phone_number }}
                        </p>
                    </div>
                @endif
            </div>
        </x-card>

        <x-card>
            <x-slot name="title">{{ __('user/profile.show.activity_info') }}</x-slot>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('user/profile.fields.last_login') }}</label>
                    <p class="text-base text-gray-900 mt-1">
                        @if($user->last_login)
                            <x-date :date="$user->last_login" type="datetime-full" />
                        @else
                            <span class="text-gray-400">{{ __('user/profile.show.labels.never_logged_in') }}</span>
                        @endif
                    </p>
                </div>

                <div>
                    <label
                        class="text-sm font-medium text-gray-500">{{ __('user/profile.show.labels.email_verified') }}</label>
                    <p class="text-base text-gray-900 mt-1">
                        @if($user->email_verified_at)
                            <x-badge variant="success" size="sm">{{ __('user/profile.show.labels.verified') }}</x-badge>
                            <span
                                class="text-sm text-gray-500 ml-2"><x-date :date="$user->email_verified_at" type="datetime-full" /></span>
                        @else
                            <x-badge variant="warning" size="sm">{{ __('user/profile.show.labels.not_verified') }}</x-badge>
                        @endif
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/profile.fields.created_at') }}</label>
                        <p class="text-base text-gray-900 mt-1"><x-date :date="$user->created_at" type="datetime-full" /></p>
                    </div>
                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('user/profile.fields.updated_at') }}</label>
                        <p class="text-base text-gray-900 mt-1"><x-date :date="$user->updated_at" type="datetime-full" /></p>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</x-layouts.user-profile>