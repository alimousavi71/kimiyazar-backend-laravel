<x-layouts.admin :title="__('admin/settings.forms.edit.title')"
    :header-title="__('admin/settings.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('admin/settings.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/settings.forms.breadcrumbs.settings')],
        ['label' => __('admin/settings.forms.breadcrumbs.edit')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/settings.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/settings.forms.edit.description') }}</p>
    </div>

    
    <x-session-messages />

    <x-card>
        <x-slot name="title">{{ __('admin/settings.forms.edit.card_title') }}</x-slot>

        <form id="settings-edit-form" action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                @foreach(\App\Enums\Database\SettingKey::cases() as $settingKey)
                    @php
                        $fieldType = $settingKey->fieldType();
                        $fieldName = "settings[{$settingKey->value}]";
                        $fieldId = "setting_{$settingKey->value}";
                        $fieldValue = old('settings.' . $settingKey->value, $settings[$settingKey->value] ?? '');
                        $placeholder = __('admin/settings.forms.placeholders.value');
                    @endphp
                    <x-form-group :label="$availableKeys[$settingKey->value] ?? $settingKey->value"
                        :error="$errors->first('settings.' . $settingKey->value)">
                        @if($fieldType === 'textarea')
                            <x-textarea name="{{ $fieldName }}" id="{{ $fieldId }}" :rows="$settingKey->textareaRows()"
                                :placeholder="$placeholder" class="w-full">{{ $fieldValue }}</x-textarea>
                        @else
                            <x-input type="{{ $fieldType }}" name="{{ $fieldName }}" id="{{ $fieldId }}"
                                :placeholder="$placeholder" value="{{ $fieldValue }}" class="w-full" />
                        @endif
                    </x-form-group>
                @endforeach
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <x-button variant="primary" type="submit">
                    {{ __('admin/settings.forms.edit.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    
    <x-card :title="__('admin/settings.modules.title')" class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="p-6 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('admin/settings.modules.countries.title') }}</h3>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="bx bxs-flag text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Country::count() }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('admin/settings.modules.countries.description') }}</p>
                </div>
                <a href="{{ route('admin.countries.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="bx bx-chevron-right text-lg"></i>
                    {{ __('admin/settings.modules.countries.manage') }}
                </a>
            </div>

            
            <div class="p-6 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('admin/settings.modules.banks.title') }}</h3>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="bx bxs-bank text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Bank::count() }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('admin/settings.modules.banks.description') }}</p>
                </div>
                <a href="{{ route('admin.banks.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="bx bx-chevron-right text-lg"></i>
                    {{ __('admin/settings.modules.banks.manage') }}
                </a>
            </div>

            
            <div class="p-6 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('admin/settings.modules.states.title') }}</h3>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="bx bxs-map text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\State::count() }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('admin/settings.modules.states.description') }}</p>
                </div>
                <a href="{{ route('admin.states.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                    <i class="bx bx-chevron-right text-lg"></i>
                    {{ __('admin/settings.modules.states.manage') }}
                </a>
            </div>
        </div>
    </x-card>

</x-layouts.admin>