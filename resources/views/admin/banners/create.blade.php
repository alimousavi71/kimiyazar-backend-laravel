<x-layouts.admin :title="__('admin/banners.forms.create.title')"
    :header-title="__('admin/banners.forms.create.header_title')" :breadcrumbs="[
        ['label' => __('admin/banners.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/banners.forms.breadcrumbs.banners'), 'url' => route('admin.banners.index')],
        ['label' => __('admin/banners.forms.breadcrumbs.create')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/banners.forms.create.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/banners.forms.create.description') }}</p>
    </div>

    <x-card>
        <x-slot name="title">{{ __('admin/banners.forms.create.card_title') }}</x-slot>

        <form id="banner-create-form" action="{{ route('admin.banners.store') }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf

            <x-form-group :label="__('admin/banners.fields.name')" required :error="$errors->first('name')">
                <x-input type="text" name="name" id="name" :placeholder="__('admin/banners.forms.placeholders.name')"
                    value="{{ old('name') }}" required class="w-full" />
            </x-form-group>

            <x-form-group :label="__('admin/banners.fields.position')" required :error="$errors->first('position')">
                @php
                    $bannerPositions = \App\Enums\Database\BannerPosition::cases();
                    $bannerDimensions = config('banner.positions', []);
                @endphp
                <div x-data="{ 
                    selectedPosition: '{{ old('position', '') }}',
                    dimensions: {{ json_encode($bannerDimensions) }}
                }">
                    <x-select name="position" id="position" class="w-full" required 
                        x-on:change="selectedPosition = $event.target.value">
                        <option value="">{{ __('admin/banners.forms.placeholders.select_position') }}</option>
                        @foreach($bannerPositions as $position)
                            @php
                                $dimensions = $bannerDimensions[$position->value] ?? ['width' => 1200, 'height' => 300];
                            @endphp
                            <option value="{{ $position->value }}" {{ old('position') === $position->value ? 'selected' : '' }}
                                data-width="{{ $dimensions['width'] }}" data-height="{{ $dimensions['height'] }}">
                                {{ $position->value }} ({{ $dimensions['width'] }}x{{ $dimensions['height'] }})
                            </option>
                        @endforeach
                    </x-select>
                    <div x-show="selectedPosition" x-transition class="mt-3">
                        <x-alert type="info" x-show="selectedPosition && dimensions[selectedPosition]">
                            <span x-text="selectedPosition && dimensions[selectedPosition] ? 
                                '{{ __('admin/banners.forms.messages.dimensions_info') }}'.replace(':width', dimensions[selectedPosition].width).replace(':height', dimensions[selectedPosition].height) : ''">
                            </span>
                        </x-alert>
                    </div>
                </div>
            </x-form-group>

            <x-form-group :label="__('admin/banners.fields.banner_file')" required
                :error="$errors->first('banner_file')">
                <x-input type="file" name="banner_file" id="banner_file"
                    accept="image/jpeg,image/png,image/jpg,image/webp" required class="w-full" />
                <p class="mt-1 text-xs text-gray-500">{{ __('admin/banners.forms.placeholders.banner_file') }}</p>
            </x-form-group>

            <x-form-group :label="__('admin/banners.fields.link')" :error="$errors->first('link')">
                <x-input type="url" name="link" id="link" :placeholder="__('admin/banners.forms.placeholders.link')"
                    value="{{ old('link') }}" class="w-full" />
            </x-form-group>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-group :label="__('admin/banners.fields.target_type')" :error="$errors->first('target_type')">
                    <x-input type="text" name="target_type" id="target_type"
                        :placeholder="__('admin/banners.forms.placeholders.target_type')"
                        value="{{ old('target_type') }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/banners.fields.target_id')" :error="$errors->first('target_id')">
                    <x-input type="number" name="target_id" id="target_id"
                        :placeholder="__('admin/banners.forms.placeholders.target_id')" value="{{ old('target_id') }}"
                        min="1" class="w-full" />
                </x-form-group>
            </div>

            <x-form-group :label="__('admin/banners.fields.is_active')">
                <x-toggle name="is_active" id="is_active" :checked="old('is_active', true)"
                    :label="__('admin/banners.forms.labels.active_banner')" />
            </x-form-group>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.banners.index') }}">
                    <x-button variant="secondary" type="button">
                        {{ __('admin/components.buttons.cancel') }}
                    </x-button>
                </a>
                <x-button variant="primary" type="submit">
                    {{ __('admin/banners.forms.create.submit') }}
                </x-button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
    @endpush
</x-layouts.admin>