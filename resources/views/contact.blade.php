@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="تماس با ما - {{ $siteTitle }}" dir="rtl">
    <!-- Page Banner Section -->
    <div class="bg-gradient-to-b from-slate-800 to-slate-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">تماس با ما</h1>
                <div class="flex items-center justify-center gap-2 text-sm md:text-base text-gray-300">
                    <a href="{{ route('home') }}" class="hover:text-green-400 transition-colors duration-300">خانه</a>
                    <i class="fa fa-angle-left text-xs"></i>
                    <span class="text-green-400">تماس با ما</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <section class="modern-map-section w-full">
        <div class="map-wrapper w-full">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3677.6962663570607!2d89.56355961427838!3d22.813715829827952!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39ff901efac79b59%3A0x5be01a1bc0dc7eba!2sAnd+IT!5e0!3m2!1sen!2sbd!4v1557901943656!5m2!1sen!2sbd"
                width="100%" height="450" frameborder="0" style="border:0" allowfullscreen="" loading="lazy"
                class="w-full">
            </iframe>
        </div>
    </section>

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
                            <form action="{{ route('contact.store') }}" method="post" class="contact-form">
                                @csrf

                                <!-- Success Message -->
                                @if(session('success'))
                                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                                        <i class="fa fa-check-circle mr-2"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Error Messages -->
                                @if($errors->any())
                                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Title Field -->
                                <div class="form-group-modern mb-5">
                                    <label for="title"
                                        class="form-label-modern block text-sm font-semibold text-slate-700 mb-2">عنوان</label>
                                    <input type="text" name="title" value="{{ old('title') }}"
                                        class="form-input-modern w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 outline-none @error('title') border-red-500 @enderror"
                                        id="title" placeholder="عنوان تماس را وارد کنید" />
                                    @error('title')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mobile & Email Row -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                    <div class="form-group-modern">
                                        <label for="mobile"
                                            class="form-label-modern block text-sm font-semibold text-slate-700 mb-2">شماره
                                            موبایل</label>
                                        <input type="text" name="mobile" value="{{ old('mobile') }}"
                                            class="form-input-modern w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 outline-none @error('mobile') border-red-500 @enderror"
                                            maxlength="11" id="mobile" placeholder="09121234567" />
                                        @error('mobile')
                                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group-modern">
                                        <label for="email"
                                            class="form-label-modern block text-sm font-semibold text-slate-700 mb-2">پست
                                            الکترونیکی</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-input-modern w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 outline-none @error('email') border-red-500 @enderror"
                                            id="email" placeholder="example@email.com" />
                                        @error('email')
                                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Message Field -->
                                <div class="form-group-modern mb-6">
                                    <label for="text"
                                        class="form-label-modern block text-sm font-semibold text-slate-700 mb-2">متن
                                        پیام</label>
                                    <textarea name="text" rows="5"
                                        class="form-textarea-modern w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 outline-none resize-none @error('text') border-red-500 @enderror"
                                        id="text"
                                        placeholder="متن پیام خود را اینجا بنویسید...">{{ old('text') }}</textarea>
                                    @error('text')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

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