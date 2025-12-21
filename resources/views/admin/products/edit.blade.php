<x-layouts.admin :title="__('admin/products.forms.edit.title')"
    :header-title="__('admin/products.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('admin/products.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/products.forms.breadcrumbs.products'), 'url' => route('admin.products.index')],
        ['label' => __('admin/products.forms.breadcrumbs.edit')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/products.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/products.forms.edit.description') }}</p>
    </div>

    <form id="product-edit-form" action="{{ route('admin.products.update', $product->id) }}" method="POST"
        class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <x-card>
            <x-slot name="title">{{ __('admin/products.forms.labels.basic_info') }}</x-slot>

            <div class="space-y-6">
                <x-form-group :label="__('admin/products.fields.name')" required :error="$errors->first('name')">
                    <x-input type="text" name="name" id="name" :placeholder="__('admin/products.forms.placeholders.name')"
                        value="{{ old('name', $product->name) }}" required class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/products.fields.slug')" :error="$errors->first('slug')">
                    <x-input type="text" name="slug" id="slug" :placeholder="__('admin/products.forms.placeholders.slug')"
                        value="{{ old('slug', $product->slug) }}" class="w-full" />
                    <p class="mt-1 text-xs text-gray-500">{{ __('admin/products.forms.placeholders.slug') }}</p>
                </x-form-group>

                <x-form-group :label="__('admin/products.fields.category')" :error="$errors->first('category_id')">
                    <x-select name="category_id" id="category_id" class="w-full">
                        <option value="">{{ __('admin/products.forms.placeholders.no_category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-select>
                </x-form-group>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form-group :label="__('admin/products.fields.unit')" required :error="$errors->first('unit')">
                        <x-select name="unit" id="unit" class="w-full" required>
                            @foreach(\App\Enums\Database\ProductUnit::cases() as $unit)
                                <option value="{{ $unit->value }}" {{ old('unit', $product->unit->value) == $unit->value ? 'selected' : '' }}>
                                    {{ $unit->label() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-form-group>

                    <x-form-group :label="__('admin/products.fields.status')" required :error="$errors->first('status')">
                        <x-select name="status" id="status" class="w-full" required>
                            @foreach(\App\Enums\Database\ProductStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status', $product->status->value) == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-form-group>
                </div>

                <x-form-group :label="__('admin/products.fields.sale_description')" :error="$errors->first('sale_description')">
                    <x-textarea name="sale_description" id="sale_description" rows="3"
                        :placeholder="__('admin/products.forms.placeholders.sale_description')"
                        class="w-full">{{ old('sale_description', $product->sale_description) }}</x-textarea>
                </x-form-group>

                <x-form-group :label="__('admin/products.fields.body')" :error="$errors->first('body')">
                    <x-textarea name="body" id="body" rows="6"
                        :placeholder="__('admin/products.forms.placeholders.body')"
                        class="w-full">{{ old('body', $product->body) }}</x-textarea>
                </x-form-group>

                <x-form-group :label="__('admin/photos.title')" :error="$errors->first('photos')">
                    <div class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md focus-within:shadow-md focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200 p-4">
                        <x-photo-manager photoable-type="{{ \App\Models\Product::class }}" :photoable-id="$product->id" :limit="10" />
                    </div>
                </x-form-group>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form-group :label="__('admin/products.fields.sort_order')" :error="$errors->first('sort_order')">
                        <x-input type="number" name="sort_order" id="sort_order"
                            :placeholder="__('admin/products.forms.placeholders.sort_order')"
                            value="{{ old('sort_order', $product->sort_order) }}" min="0" class="w-full" />
                    </x-form-group>

                    <x-form-group :label="__('admin/products.fields.is_published')">
                        <x-toggle name="is_published" id="is_published" :checked="old('is_published', $product->is_published)"
                            :label="__('admin/products.forms.labels.published_product')" />
                    </x-form-group>
                </div>
            </div>
        </x-card>

        <!-- Pricing Information -->
        <x-card>
            <x-slot name="title">{{ __('admin/products.forms.labels.pricing_info') }}</x-slot>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form-group :label="__('admin/products.fields.current_price')" :error="$errors->first('current_price')">
                        <x-input type="number" name="current_price" id="current_price" step="0.01"
                            :placeholder="__('admin/products.forms.placeholders.current_price')"
                            value="{{ old('current_price', $product->current_price) }}" min="0" class="w-full" />
                    </x-form-group>

                    <x-form-group :label="__('admin/products.fields.currency_code')" :error="$errors->first('currency_code')">
                        <x-select name="currency_code" id="currency_code" class="w-full">
                            <option value="">{{ __('admin/components.status.select') }}</option>
                            @foreach(\App\Enums\Database\CurrencyCode::cases() as $currency)
                                <option value="{{ $currency->value }}" {{ old('currency_code', $product->currency_code?->value) == $currency->value ? 'selected' : '' }}>
                                    {{ $currency->label() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-form-group>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form-group :label="__('admin/products.fields.price_label')" :error="$errors->first('price_label')">
                        <x-input type="text" name="price_label" id="price_label"
                            :placeholder="__('admin/products.forms.placeholders.price_label')"
                            value="{{ old('price_label', $product->price_label) }}" class="w-full" />
                    </x-form-group>

                    <x-form-group :label="__('admin/products.fields.price_effective_date')" :error="$errors->first('price_effective_date')">
                        <x-input type="date" name="price_effective_date" id="price_effective_date"
                            value="{{ old('price_effective_date', $product->price_effective_date?->format('Y-m-d')) }}" class="w-full" />
                    </x-form-group>
                </div>
            </div>
        </x-card>

        <!-- SEO Information -->
        <x-card>
            <x-slot name="title">{{ __('admin/products.forms.labels.seo_info') }}</x-slot>

            <div class="space-y-6">
                <x-form-group :label="__('admin/products.fields.meta_title')" :error="$errors->first('meta_title')">
                    <x-input type="text" name="meta_title" id="meta_title" maxlength="255"
                        :placeholder="__('admin/products.forms.placeholders.meta_title')"
                        value="{{ old('meta_title', $product->meta_title) }}" class="w-full" />
                </x-form-group>

                <x-form-group :label="__('admin/products.fields.meta_description')" :error="$errors->first('meta_description')">
                    <x-textarea name="meta_description" id="meta_description" rows="3"
                        :placeholder="__('admin/products.forms.placeholders.meta_description')"
                        class="w-full">{{ old('meta_description', $product->meta_description) }}</x-textarea>
                </x-form-group>

                <x-form-group :label="__('admin/products.fields.meta_keywords')" :error="$errors->first('meta_keywords')">
                    <x-textarea name="meta_keywords" id="meta_keywords" rows="2"
                        :placeholder="__('admin/products.forms.placeholders.meta_keywords')"
                        class="w-full">{{ old('meta_keywords', $product->meta_keywords) }}</x-textarea>
                </x-form-group>
            </div>
        </x-card>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.products.index') }}">
                <x-button variant="secondary" type="button">
                    {{ __('admin/components.buttons.cancel') }}
                </x-button>
            </a>
            <x-button variant="primary" type="submit">
                {{ __('admin/products.forms.edit.submit') }}
            </x-button>
        </div>
    </form>

    @push('scripts')
        @vite(['resources/js/admin-form-validation.js', 'resources/js/form-with-photos.js'])
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                initFormWithPhotos({
                    formId: 'product-edit-form',
                    photoManagerSelector: '[id^="photo-manager-"]',
                    photoableType: '{{ \App\Models\Product::class }}',
                    photoableId: {{ $product->id }},
                    redirectUrl: '{{ route('admin.products.index') }}',
                    successMessage: '{{ __('admin/products.messages.updated') }}',
                    errorMessage: '{{ __('admin/products.messages.update_failed') }}',
                });
            });
        </script>
    @endpush
</x-layouts.admin>
