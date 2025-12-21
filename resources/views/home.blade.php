@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp
<x-layouts.app title="{{ $siteTitle }}" dir="rtl">
    <!-- Top Area -->
    <x-web.top-bar :settings="$settings" />

    <!-- Navigation -->
    <x-web.navigation />

    <!-- Hero Slider Section -->
    <x-web.slider :sliders="$sliders" />

    <!-- Products Section -->
    <x-web.products-section :products="$products" />

    <!-- Categories Section -->
    <x-web.categories-section :categories="$rootCategories" />

    <!-- Services Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-2">خدمات ما</h2>
                <p class="text-gray-600">خدمات متنوع و با کیفیت</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service Card 1 -->
                <div class="bg-white rounded-xl border border-gray-200 transition-all duration-300 overflow-hidden flex flex-col shadow-sm hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.08)] hover:border-green-200">
                    <div class="p-7.5 pb-5 text-center bg-white border-b border-gray-100 transition-all duration-300">
                        <div class="w-17.5 h-17.5 mx-auto mb-5 bg-white rounded-lg flex items-center justify-center transition-all duration-300 shadow-[0_2px_4px_rgba(0,0,0,0.1)] group-hover:scale-110 group-hover:-translate-y-1.25 group-hover:shadow-[0_4px_8px_rgba(40,167,69,0.3)]">
                            <i class="fas fa-shipping-fast text-4xl text-green-500"></i>
                        </div>
                    </div>
                    <div class="p-6 flex-1">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 leading-snug transition-colors duration-300 group-hover:text-green-500">ارسال سریع</h3>
                        <p class="text-sm text-slate-700 leading-relaxed min-h-[120px]">ارسال سریع و ایمن محصولات به سراسر کشور با بهترین روش‌های حمل و نقل</p>
                    </div>
                    <div class="p-4 pt-0 border-t border-gray-100 bg-white transition-all duration-300">
                        <a href="#" class="inline-flex items-center gap-2 text-green-500 no-underline text-sm font-semibold transition-all duration-300 hover:gap-3 hover:text-emerald-400">
                            <span>اطلاعات بیشتر</span>
                            <i class="fas fa-arrow-left text-xs transition-all duration-300 hover:-translate-x-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Service Card 2 -->
                <div class="bg-white rounded-xl border border-gray-200 transition-all duration-300 overflow-hidden flex flex-col shadow-sm hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.08)] hover:border-green-200">
                    <div class="p-7.5 pb-5 text-center bg-white border-b border-gray-100 transition-all duration-300">
                        <div class="w-17.5 h-17.5 mx-auto mb-5 bg-white rounded-lg flex items-center justify-center transition-all duration-300 shadow-[0_2px_4px_rgba(0,0,0,0.1)] group-hover:scale-110 group-hover:-translate-y-1.25 group-hover:shadow-[0_4px_8px_rgba(40,167,69,0.3)]">
                            <i class="fas fa-shield-alt text-4xl text-green-500"></i>
                        </div>
                    </div>
                    <div class="p-6 flex-1">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 leading-snug transition-colors duration-300 group-hover:text-green-500">گارانتی معتبر</h3>
                        <p class="text-sm text-slate-700 leading-relaxed min-h-[120px]">تمام محصولات ما دارای گارانتی معتبر و خدمات پس از فروش کامل هستند</p>
                    </div>
                    <div class="p-4 pt-0 border-t border-gray-100 bg-white transition-all duration-300">
                        <a href="#" class="inline-flex items-center gap-2 text-green-500 no-underline text-sm font-semibold transition-all duration-300 hover:gap-3 hover:text-emerald-400">
                            <span>اطلاعات بیشتر</span>
                            <i class="fas fa-arrow-left text-xs transition-all duration-300 hover:-translate-x-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Service Card 3 -->
                <div class="bg-white rounded-xl border border-gray-200 transition-all duration-300 overflow-hidden flex flex-col shadow-sm hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.08)] hover:border-green-200">
                    <div class="p-7.5 pb-5 text-center bg-white border-b border-gray-100 transition-all duration-300">
                        <div class="w-17.5 h-17.5 mx-auto mb-5 bg-white rounded-lg flex items-center justify-center transition-all duration-300 shadow-[0_2px_4px_rgba(0,0,0,0.1)] group-hover:scale-110 group-hover:-translate-y-1.25 group-hover:shadow-[0_4px_8px_rgba(40,167,69,0.3)]">
                            <i class="fas fa-headset text-4xl text-green-500"></i>
                        </div>
                    </div>
                    <div class="p-6 flex-1">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 leading-snug transition-colors duration-300 group-hover:text-green-500">پشتیبانی 24/7</h3>
                        <p class="text-sm text-slate-700 leading-relaxed min-h-[120px]">تیم پشتیبانی ما در تمام ساعات شبانه‌روز آماده پاسخگویی به سوالات شماست</p>
                    </div>
                    <div class="p-4 pt-0 border-t border-gray-100 bg-white transition-all duration-300">
                        <a href="#" class="inline-flex items-center gap-2 text-green-500 no-underline text-sm font-semibold transition-all duration-300 hover:gap-3 hover:text-emerald-400">
                            <span>اطلاعات بیشتر</span>
                            <i class="fas fa-arrow-left text-xs transition-all duration-300 hover:-translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    @if($news->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">آخرین اخبار</h2>
                    <p class="text-gray-600">از آخرین اخبار و رویدادها مطلع شوید</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news as $item)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 shadow-sm hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.08)] hover:border-green-200">
                            <a href="#" class="flex flex-col h-full no-underline text-inherit hover:no-underline">
                                <div class="relative w-full pt-[65%] overflow-hidden bg-gray-100">
                                    @if($item->photos->first())
                                        <img src="{{ $item->photos->first()->url }}" alt="{{ $item->title }}" class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-400 group-hover:scale-105">
                                    @endif
                                    <div class="absolute top-3 right-3 bg-gradient-to-r from-green-500 to-emerald-400 text-white px-3 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5 shadow-[0_2px_8px_rgba(40,167,69,0.4)]">
                                        <i class="fas fa-calendar text-xs"></i>
                                        <span>{{ $item->created_at->format('Y-m-d') }}</span>
                                    </div>
                                </div>
                                <div class="p-5 flex-1 flex flex-col min-h-[120px]">
                                    <h3 class="text-base font-bold text-slate-800 mb-4 line-clamp-2 flex-1 transition-colors duration-300 group-hover:text-green-500">{{ $item->title }}</h3>
                                    <div class="mt-auto flex items-center justify-between">
                                        <span class="inline-flex items-center gap-2 text-green-500 text-xs font-semibold transition-all duration-300 group-hover:gap-3 group-hover:text-emerald-400">
                                            <span>ادامه مطلب</span>
                                            <i class="fas fa-arrow-left text-xs transition-all duration-300 group-hover:-translate-x-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="#" class="inline-flex items-center gap-2.5 px-7 py-3 bg-white text-green-500 no-underline rounded-lg border border-green-200 font-semibold text-sm transition-all duration-300 shadow-sm hover:bg-green-500 hover:text-white hover:border-green-500 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(40,167,69,0.2)]">
                        <span>مشاهده همه اخبار</span>
                        <i class="fas fa-arrow-left text-xs transition-transform duration-300 group-hover:-translate-x-1"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-slate-800 to-slate-900 text-gray-200 font-['IRANSans',sans-serif] relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 via-emerald-400 to-green-500 bg-[length:200%_100%] animate-[gradient_3s_ease_infinite]"></div>
        <div class="container mx-auto px-4 py-15">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="mb-5">
                    <div class="flex items-center gap-4 mb-5">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-15 h-15 object-contain brightness-0 invert" onerror="this.style.display='none'">
                        <h3 class="text-2xl font-bold text-white m-0">{{ $settings['title'] ?? config('app.name') }}</h3>
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6 text-sm">{{ $settings['description'] ?? '' }}</p>
                    <div class="flex gap-3 flex-wrap">
                        @if($settings['telegram'] ?? null)
                            <a href="{{ $settings['telegram'] }}" target="_blank" class="w-10.5 h-10.5 bg-white/10 border-2 border-transparent rounded-full flex items-center justify-center text-gray-300 text-base no-underline transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-emerald-400 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]">
                                <i class="fab fa-telegram"></i>
                            </a>
                        @endif
                        @if($settings['instagram'] ?? null)
                            <a href="{{ $settings['instagram'] }}" target="_blank" class="w-10.5 h-10.5 bg-white/10 border-2 border-transparent rounded-full flex items-center justify-center text-gray-300 text-base no-underline transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-emerald-400 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="mb-5">
                    <h4 class="text-lg font-bold text-white mb-5 pb-3 border-b-2 border-green-500 inline-block relative">
                        <span class="absolute bottom-[-2px] right-0 w-2/5 h-0.5 bg-emerald-400"></span>
                        لینک‌های سریع
                    </h4>
                    <ul class="list-none p-0 m-0">
                        <li class="mb-3">
                            <a href="#" class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                <i class="fas fa-chevron-left text-xs transition-transform duration-300"></i>
                                <span>خانه</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="#" class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                <i class="fas fa-chevron-left text-xs transition-transform duration-300"></i>
                                <span>محصولات</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="#" class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                <i class="fas fa-chevron-left text-xs transition-transform duration-300"></i>
                                <span>اخبار</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="#" class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                <i class="fas fa-chevron-left text-xs transition-transform duration-300"></i>
                                <span>درباره ما</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="mb-5">
                    <h4 class="text-lg font-bold text-white mb-5 pb-3 border-b-2 border-green-500 inline-block relative">
                        <span class="absolute bottom-[-2px] right-0 w-2/5 h-0.5 bg-emerald-400"></span>
                        تماس با ما
                    </h4>
                    <ul class="list-none p-0 m-0">
                        @if($settings['address'] ?? null)
                            <li class="mb-3 flex items-start gap-3">
                                <div class="w-12.5 h-12.5 min-w-12.5 bg-gradient-to-br from-green-500 to-emerald-400 rounded-full flex items-center justify-center shadow-[0_4px_12px_rgba(40,167,69,0.2)]">
                                    <i class="fas fa-map-marker-alt text-white text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-300 m-0 mb-1">آدرس</p>
                                    <p class="text-sm text-gray-400 leading-relaxed m-0">{{ $settings['address'] }}</p>
                                </div>
                            </li>
                        @endif
                        @if($settings['tel'] ?? null)
                            <li class="mb-3 flex items-start gap-3">
                                <div class="w-12.5 h-12.5 min-w-12.5 bg-gradient-to-br from-green-500 to-emerald-400 rounded-full flex items-center justify-center shadow-[0_4px_12px_rgba(40,167,69,0.2)]">
                                    <i class="fas fa-phone text-white text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-300 m-0 mb-1">تلفن</p>
                                    <a href="tel:{{ $settings['tel'] }}" class="text-sm text-gray-400 no-underline transition-colors duration-300 hover:text-green-500">{{ $settings['tel'] }}</a>
                                </div>
                            </li>
                        @endif
                        @if($settings['email'] ?? null)
                            <li class="mb-3 flex items-start gap-3">
                                <div class="w-12.5 h-12.5 min-w-12.5 bg-gradient-to-br from-green-500 to-emerald-400 rounded-full flex items-center justify-center shadow-[0_4px_12px_rgba(40,167,69,0.2)]">
                                    <i class="fas fa-envelope text-white text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-300 m-0 mb-1">ایمیل</p>
                                    <a href="mailto:{{ $settings['email'] }}" class="text-sm text-gray-400 no-underline transition-colors duration-300 hover:text-green-500">{{ $settings['email'] }}</a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="mb-5">
                    <h4 class="text-lg font-bold text-white mb-5 pb-3 border-b-2 border-green-500 inline-block relative">
                        <span class="absolute bottom-[-2px] right-0 w-2/5 h-0.5 bg-emerald-400"></span>
                        خبرنامه
                    </h4>
                    <p class="text-sm text-gray-300 leading-relaxed mb-4">برای دریافت آخرین اخبار و تخفیف‌ها در خبرنامه ما عضو شوید</p>
                    <form class="flex gap-0 border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 focus-within:border-green-500 focus-within:shadow-[0_0_0_3px_rgba(40,167,69,0.1)]">
                        <input type="email" placeholder="ایمیل شما" class="flex-1 px-4 py-3 border-none outline-none text-sm bg-white rtl">
                        <button type="submit" class="border-none bg-green-500 text-white px-4 cursor-pointer transition-all duration-300 hover:bg-emerald-400">
                            <i class="fas fa-paper-plane text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="bg-black/30 py-5 border-t border-white/10">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-300 m-0">
                        <strong class="text-green-500 font-bold">© {{ date('Y') }}</strong> تمام حقوق محفوظ است.
                    </p>
                    <p class="text-sm text-gray-300 m-0">
                        طراحی شده با <i class="fas fa-heart text-red-500 mx-1 animate-[heartbeat_1.5s_ease-in-out_infinite]"></i> توسط تیم ما
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <div class="fixed bottom-8 left-8 z-[999]">
        <a href="#" class="w-12.5 h-12.5 bg-gradient-to-br from-green-500 to-emerald-400 text-white flex items-center justify-center rounded-full no-underline text-lg shadow-[0_4px_15px_rgba(40,167,69,0.4)] border-3 border-white/20 transition-all duration-300 hover:-translate-y-1.25 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)]">
            <i class="fas fa-arrow-up animate-[bounceUp_2s_ease-in-out_infinite]"></i>
        </a>
    </div>

    @push('scripts')
        <script>
            // Mobile menu toggle
            document.addEventListener('DOMContentLoaded', function() {
                const toggle = document.getElementById('mobile-menu-toggle');
                const menu = document.getElementById('mobile-menu');
                
                if (toggle && menu) {
                    toggle.addEventListener('click', function() {
                        menu.classList.toggle('hidden');
                        const spans = toggle.querySelectorAll('span');
                        if (!menu.classList.contains('hidden')) {
                            spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                            spans[1].style.opacity = '0';
                            spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
                        } else {
                            spans[0].style.transform = '';
                            spans[1].style.opacity = '';
                            spans[2].style.transform = '';
                        }
                    });
                }

                // Search toggle
                const searchToggle = document.getElementById('search-toggle');
                const searchWrapper = document.getElementById('search-form-wrapper');
                
                if (searchToggle && searchWrapper) {
                    searchToggle.addEventListener('click', function() {
                        searchWrapper.classList.toggle('opacity-0');
                        searchWrapper.classList.toggle('invisible');
                        searchWrapper.classList.toggle('pointer-events-none');
                    });
                }

                // Category filter auto-submit
                const categoryFilter = document.getElementById('home-category-filter');
                if (categoryFilter) {
                    const hiddenSelect = categoryFilter.closest('.category-selector-wrapper')?.querySelector('select');
                    if (hiddenSelect) {
                        hiddenSelect.addEventListener('change', function() {
                            document.getElementById('product-filter-form').submit();
                        });
                    }
                }
            });
        </script>
        @vite(['resources/js/category-selector.js'])
    @endpush

    <style>
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        @keyframes bounceUp {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
    </style>
</x-layouts.app>
