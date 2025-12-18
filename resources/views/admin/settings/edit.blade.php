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

    <!-- Success/Error Messages -->
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

</x-layouts.admin>