@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="تماس با ما - {{ $siteTitle }}" dir="rtl">
    <x-web.page-banner title="تماس با ما" />

    <!-- Contact Content Section -->
    <section class="modern-contact-section py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Contact Information -->
                <div class="lg:col-span-5">
                    <div class="contact-info-wrapper bg-white rounded-xl shadow-lg p-6 md:p-8">
                        <div class="contact-info-header mb-8">
                            <h2 class="contact-info-title text-2xl md:text-3xl font-bold text-slate-800 mb-2">اطلاعات
                                تماس</h2>
                            <p class="contact-info-subtitle text-gray-600">راه‌های ارتباطی با ما</p>
                        </div>

                        <!-- Contact Cards -->
                        <div class="contact-cards space-y-4">
                            <!-- Address Card -->
                            <div
                                class="contact-card flex items-start gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200 transition-all duration-300 hover:shadow-md hover:border-green-200">
                                <div
                                    class="contact-card-icon w-12 h-12 min-w-12 bg-gradient-to-br from-green-500 to-emerald-400 rounded-full flex items-center justify-center shadow-[0_4px_12px_rgba(40,167,69,0.2)]">
                                    <i class="fa fa-map-marker text-white text-lg"></i>
                                </div>
                                <div class="contact-card-content flex-1">
                                    <h4 class="contact-card-title text-lg font-bold text-slate-800 mb-1">آدرس</h4>
                                    <p class="contact-card-text text-gray-600 text-sm leading-relaxed">
                                        {{ $settings['address'] ?? 'آدرس در حال بروزرسانی است' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Phone Card -->
                            <div
                                class="contact-card flex items-start gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200 transition-all duration-300 hover:shadow-md hover:border-green-200">
                                <div
                                    class="contact-card-icon w-12 h-12 min-w-12 bg-gradient-to-br from-green-500 to-emerald-400 rounded-full flex items-center justify-center shadow-[0_4px_12px_rgba(40,167,69,0.2)]">
                                    <i class="fa fa-phone text-white text-lg"></i>
                                </div>
                                <div class="contact-card-content flex-1">
                                    <h4 class="contact-card-title text-lg font-bold text-slate-800 mb-2">تلفن تماس</h4>
                                    @if($settings['tel'] ?? null)
                                        <p class="contact-card-text text-gray-600 mb-1">
                                            <a href="tel:{{ $settings['tel'] }}"
                                                class="hover:text-green-500 transition-colors duration-300">{{ $settings['tel'] }}</a>
                                        </p>
                                    @endif
                                    @if($settings['mobile'] ?? null)
                                        <p class="contact-card-text text-gray-600">
                                            <a href="tel:{{ $settings['mobile'] }}"
                                                class="hover:text-green-500 transition-colors duration-300">{{ $settings['mobile'] }}</a>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Email & Social Card -->
                            <div
                                class="contact-card flex items-start gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200 transition-all duration-300 hover:shadow-md hover:border-green-200">
                                <div
                                    class="contact-card-icon w-12 h-12 min-w-12 bg-gradient-to-br from-green-500 to-emerald-400 rounded-full flex items-center justify-center shadow-[0_4px_12px_rgba(40,167,69,0.2)]">
                                    <i class="fa fa-envelope text-white text-lg"></i>
                                </div>
                                <div class="contact-card-content flex-1">
                                    <h4 class="contact-card-title text-lg font-bold text-slate-800 mb-2">ایمیل و
                                        شبکه‌های اجتماعی</h4>
                                    @if($settings['email'] ?? null)
                                        <p class="contact-card-text text-gray-600 mb-4">
                                            <a href="mailto:{{ $settings['email'] }}"
                                                class="hover:text-green-500 transition-colors duration-300">{{ $settings['email'] }}</a>
                                        </p>
                                    @endif
                                    <div class="contact-social-links flex gap-3">
                                        @if($settings['telegram'] ?? null)
                                            <a href="{{ $settings['telegram'] }}" target="_blank" rel="noopener noreferrer"
                                                class="contact-social-icon w-10 h-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center text-gray-600 transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-green-500 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]"
                                                title="تلگرام">
                                                <i class="fa fa-paper-plane text-sm"></i>
                                            </a>
                                        @endif
                                        @if($settings['instagram'] ?? null)
                                            <a href="{{ $settings['instagram'] }}" target="_blank" rel="noopener noreferrer"
                                                class="contact-social-icon w-10 h-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center text-gray-600 transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-green-500 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]"
                                                title="اینستاگرام">
                                                <i class="fa fa-instagram text-sm"></i>
                                            </a>
                                        @endif
                                        @if($settings['email'] ?? null)
                                            <a href="mailto:{{ $settings['email'] }}"
                                                class="contact-social-icon w-10 h-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center text-gray-600 transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-green-500 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]"
                                                title="ایمیل">
                                                <i class="fa fa-google text-sm"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-7">
                    <div class="contact-form-wrapper bg-white rounded-xl shadow-lg p-6 md:p-8">
                        <div class="contact-form-header text-center mb-8">
                            <div
                                class="form-header-icon w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-500 to-emerald-400 rounded-full flex items-center justify-center shadow-[0_4px_12px_rgba(40,167,69,0.3)]">
                                <i class="fa fa-paper-plane text-white text-2xl"></i>
                            </div>
                            <h2 class="contact-form-title text-2xl md:text-3xl font-bold text-slate-800 mb-2">ارسال پیام
                            </h2>
                            <p class="contact-form-subtitle text-gray-600">پیام خود را برای ما ارسال کنید، در اسرع وقت
                                پاسخ خواهیم داد</p>
                        </div>

                        <div class="modern-contact-form">
                            <form id="contact-form" action="{{ route('contact.store') }}" method="post"
                                class="contact-form space-y-6">
                                @csrf

                                <!-- Success Message -->
                                @if(session('success'))
                                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                                        <i class="fa fa-check-circle mr-2"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Error Messages -->
                                @if($errors->any())
                                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Title Field -->
                                <x-form-group label="عنوان" required :error="$errors->first('title')">
                                    <x-input type="text" name="title" id="title" :value="old('title')"
                                        placeholder="عنوان تماس را وارد کنید" class="w-full" />
                                </x-form-group>

                                <!-- Mobile & Email Row -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-form-group label="شماره موبایل" required :error="$errors->first('mobile')">
                                        <x-input type="text" name="mobile" id="mobile" :value="old('mobile')"
                                            maxlength="11" placeholder="09121234567" class="w-full" />
                                    </x-form-group>

                                    <x-form-group label="پست الکترونیکی" required :error="$errors->first('email')">
                                        <x-input type="email" name="email" id="email" :value="old('email')"
                                            placeholder="example@email.com" class="w-full" />
                                    </x-form-group>
                                </div>

                                <!-- Message Field -->
                                <x-form-group label="متن پیام" required :error="$errors->first('text')">
                                    <x-textarea name="text" id="text" rows="5"
                                        placeholder="متن پیام خود را اینجا بنویسید..."
                                        class="w-full">{{ old('text') }}</x-textarea>
                                </x-form-group>

                                <!-- Submit Button -->
                                <div class="form-submit-wrapper">
                                    <button type="submit"
                                        class="btn-submit-modern w-full md:w-auto px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-lg font-semibold text-base transition-all duration-300 shadow-[0_2px_10px_rgba(40,167,69,0.3)] hover:-translate-y-1 hover:scale-105 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)] hover:from-emerald-400 hover:to-green-500">
                                        <i class="fa fa-paper-plane mr-2"></i>
                                        ارسال پیام
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        @vite(['resources/js/contact-form-validation.js'])
    @endpush
</x-layouts.app>