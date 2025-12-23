@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

@vite('resources/js/price-inquiry-validation.js')

<x-layouts.app title="{{ __('price-inquiry.forms.create.title') }} - {{ $siteTitle }}" dir="rtl">
    <x-web.page-banner :title="__('price-inquiry.forms.create.title')" />

    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">
                            {{ __('price-inquiry.forms.create.title') }}
                        </h2>
                        <p class="text-gray-600 text-sm md:text-base">
                            {{ __('price-inquiry.forms.create.description') }}
                        </p>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-visible">
                        <form action="{{ route('price-inquiry.store') }}" method="POST" id="price-inquiry-form"
                            class="p-6 space-y-6" x-data="productSelector()">
                            @csrf

                            <!-- Personal Information -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    {{ __('price-inquiry.forms.create.personal_info') }}
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input type="text" name="first_name" id="first_name"
                                        :label="__('price-inquiry.fields.first_name')"
                                        :value="old('first_name', $user->first_name ?? '')"
                                        :required="true"
                                        :disabled="(bool) $user" />

                                    <x-input type="text" name="last_name" id="last_name"
                                        :label="__('price-inquiry.fields.last_name')"
                                        :value="old('last_name', $user->last_name ?? '')"
                                        :required="true"
                                        :disabled="(bool) $user" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <x-input type="email" name="email" id="email"
                                        :label="__('price-inquiry.fields.email')"
                                        :value="old('email', $user->email ?? '')"
                                        :required="true"
                                        :disabled="(bool) $user" />

                                    <x-input type="text" name="phone_number" id="phone_number"
                                        :label="__('price-inquiry.fields.phone_number')"
                                        :value="old('phone_number', $user->phone_number ?? '')"
                                        :required="true"
                                        :disabled="(bool) $user" />
                                </div>

                                @if($user)
                                    <!-- Hidden inputs to ensure disabled fields are submitted -->
                                    <input type="hidden" name="first_name"
                                        value="{{ old('first_name', $user->first_name ?? '') }}">
                                    <input type="hidden" name="last_name"
                                        value="{{ old('last_name', $user->last_name ?? '') }}">
                                    <input type="hidden" name="email" value="{{ old('email', $user->email ?? '') }}">
                                    <input type="hidden" name="phone_number"
                                        value="{{ old('phone_number', $user->phone_number ?? '') }}">
                                @endif
                            </div>

                            <!-- Products Selection -->
                            <div id="products-section">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    {{ __('price-inquiry.forms.create.products_section') }}
                                </h3>

                                <!-- Products Error Container -->
                                <div id="products-error-container" class="mb-4"></div>

                                <div class="space-y-4">
                                    <!-- Product Selection Input with Add Button -->
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            <x-select2 id="product-select-single"
                                                :label="__('price-inquiry.fields.product')"
                                                remote-url="{{ route('api.products.search') }}" remote-search
                                                :min-input-length="2" search-param="q" value-key="id" text-key="name"
                                                :placeholder="__('price-inquiry.forms.create.select_product')"
                                                allow-clear />
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" @click="addSelectedProduct()"
                                                x-bind:disabled="!selectedProduct || !canAddMore() || isProductAlreadyAdded()"
                                                class="px-6 py-2.5 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors font-semibold disabled:bg-gray-300 disabled:cursor-not-allowed whitespace-nowrap">
                                                <i
                                                    class="fa fa-plus me-2"></i>{{ __('price-inquiry.forms.create.add_product') }}
                                            </button>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-500">
                                        {{ __('price-inquiry.forms.create.products_help') }}
                                        <span x-show="selectedProducts.length > 0"
                                            x-text="`(${selectedProducts.length}/5)`"
                                            class="font-medium text-gray-700"></span>
                                    </p>

                                    <!-- Selected Products List -->
                                    <div x-show="selectedProducts.length > 0" class="space-y-2">
                                        <template x-for="(product, index) in selectedProducts" :key="product.id">
                                            <div
                                                class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                                <div class="flex items-center gap-3">
                                                    <span class="text-gray-500 font-medium" x-text="index + 1"></span>
                                                    <span class="text-gray-900 font-medium"
                                                        x-text="product.name"></span>
                                                </div>
                                                <button type="button" @click="removeProduct(index)"
                                                    class="text-red-500 hover:text-red-700 p-1 transition-colors">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <!-- Hidden input for form submission -->
                                                <input type="hidden" :name="`products[]`" :value="product.id" />
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <button type="submit" x-bind:disabled="selectedProducts.length === 0"
                                    class="px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors font-semibold disabled:bg-gray-300 disabled:cursor-not-allowed">
                                    {{ __('price-inquiry.forms.create.submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            function productSelector() {
                return {
                    selectedProducts: [],
                    selectedProduct: null,
                    maxProducts: 5,

                    init() {
                        // Listen for Select2 selection event
                        window.addEventListener('select2-selected', (e) => {
                            if (e.detail.selectId === 'product-select-single') {
                                this.selectedProduct = {
                                    id: e.detail.value,
                                    name: e.detail.text
                                };
                            }
                        });

                        // Listen for Select2 clear event
                        window.addEventListener('select2-cleared', (e) => {
                            if (e.detail.selectId === 'product-select-single') {
                                this.selectedProduct = null;
                            }
                        });
                    },

                    handleProductSelected(detail) {
                        if (detail.selectId === 'product-select-single') {
                            this.selectedProduct = {
                                id: detail.value,
                                name: detail.text
                            };
                        }
                    },

                    addSelectedProduct() {
                        if (!this.selectedProduct || !this.canAddMore()) {
                            return;
                        }

                        // Check if product is already added
                        if (this.selectedProducts.find(p => p.id == this.selectedProduct.id)) {
                            return;
                        }

                        // Add product
                        this.selectedProducts.push({ ...this.selectedProduct });

                        // Clear selection
                        this.selectedProduct = null;

                        // Clear Select2 selection
                        this.$nextTick(() => {
                            if (window.clearSelect2) {
                                window.clearSelect2('product-select-single');
                            }
                        });
                    },

                    removeProduct(index) {
                        this.selectedProducts.splice(index, 1);
                    },

                    canAddMore() {
                        return this.selectedProducts.length < this.maxProducts;
                    },

                    isProductAlreadyAdded() {
                        if (!this.selectedProduct) return false;
                        return this.selectedProducts.some(p => p.id == this.selectedProduct.id);
                    }
                };
            }
        </script>
    @endpush
</x-layouts.app>