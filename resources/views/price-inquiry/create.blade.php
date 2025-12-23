@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

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
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <form action="{{ route('price-inquiry.store') }}" method="POST" id="price-inquiry-form"
                            class="p-6 space-y-6">
                            @csrf

                            <!-- Personal Information -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    {{ __('price-inquiry.forms.create.personal_info') }}
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="first_name"
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('price-inquiry.fields.first_name') }}
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" name="first_name" id="first_name"
                                            value="{{ old('first_name', $user->first_name ?? '') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                                            required>
                                    </div>

                                    <div>
                                        <label for="last_name"
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('price-inquiry.fields.last_name') }}
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" name="last_name" id="last_name"
                                            value="{{ old('last_name', $user->last_name ?? '') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                                            required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('price-inquiry.fields.email') }}
                                            <span class="text-red-500">*</span></label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $user->email ?? '') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                                            required>
                                    </div>

                                    <div>
                                        <label for="phone_number"
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('price-inquiry.fields.phone_number') }}
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" name="phone_number" id="phone_number"
                                            value="{{ old('phone_number', $user->phone_number ?? '') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Selection -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    {{ __('price-inquiry.forms.create.products_section') }}
                                </h3>

                                <div>
                                    <x-select2 name="products[]" id="products-select"
                                        :label="__('price-inquiry.fields.products')"
                                        remote-url="{{ route('api.products.search') }}" remote-search
                                        :min-input-length="2" search-param="q" value-key="id" text-key="name"
                                        :placeholder="__('price-inquiry.forms.create.select_products')" multiple
                                        allow-clear required />
                                    <p class="text-sm text-gray-500 mt-2">
                                        {{ __('price-inquiry.forms.create.products_help') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <button type="submit"
                                    class="px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors font-semibold">
                                    {{ __('price-inquiry.forms.create.submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>