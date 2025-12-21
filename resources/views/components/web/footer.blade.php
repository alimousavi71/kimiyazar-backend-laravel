@php
    // Settings are automatically provided by SettingComposer for frontend views
    $settings = $settings ?? [];
    $siteTitle = $settings['title'] ?? config('app.name', 'کیمیا تجارت زر');

    // Fetch popular tags (limit 10)
    $tags = \App\Models\Tag::orderBy('created_at', 'desc')->limit(10)->get();
@endphp

<footer class="modern-footer bg-gradient-to-b from-slate-800 to-slate-900 text-gray-200 relative overflow-hidden">
    <div class="footer-main py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-12 gap-6">
                <!-- Company Info Section -->
                <div class="col-span-12 sm:col-span-12 md:col-span-6 lg:col-span-3 mb-4">
                    <div class="footer-section">
                        <div class="footer-logo-section flex items-center gap-4 mb-5">
                            <img src="{{ asset('images/logo.png') }}" alt="{{ $siteTitle }}"
                                class="footer-logo-img w-15 h-15 object-contain brightness-0 invert"
                                onerror="this.style.display='none'">
                            <h3 class="footer-brand text-2xl font-bold text-white m-0">{{ $siteTitle }}</h3>
                        </div>
                        <p class="footer-description text-sm text-gray-300 leading-relaxed mb-6">
                            {{ $settings['description'] ?? 'ارائه دهنده خدمات وارادت و صادرات مواد شیمیایی و صنعتی با بالاترین کیفیت' }}
                        </p>
                        <div class="footer-social flex gap-3 flex-wrap">
                            @if($settings['telegram'] ?? null)
                                <a href="{{ $settings['telegram'] }}" target="_blank"
                                    class="social-icon w-10.5 h-10.5 bg-white/10 border-2 border-transparent rounded-full flex items-center justify-center text-gray-300 text-base no-underline transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-emerald-400 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]"
                                    title="تلگرام">
                                    <i class="fa fa-paper-plane"></i>
                                </a>
                            @endif
                            @if($settings['instagram'] ?? null)
                                <a href="{{ $settings['instagram'] }}" target="_blank"
                                    class="social-icon w-10.5 h-10.5 bg-white/10 border-2 border-transparent rounded-full flex items-center justify-center text-gray-300 text-base no-underline transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-emerald-400 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]"
                                    title="اینستاگرام">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            @endif
                            @if($settings['tel'] ?? null)
                                <a href="tel:{{ $settings['tel'] }}"
                                    class="social-icon w-10.5 h-10.5 bg-white/10 border-2 border-transparent rounded-full flex items-center justify-center text-gray-300 text-base no-underline transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-emerald-400 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]"
                                    title="تماس">
                                    <i class="fa fa-phone"></i>
                                </a>
                            @endif
                            @if($settings['email'] ?? null)
                                <a href="mailto:{{ $settings['email'] }}"
                                    class="social-icon w-10.5 h-10.5 bg-white/10 border-2 border-transparent rounded-full flex items-center justify-center text-gray-300 text-base no-underline transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-emerald-400 hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]"
                                    title="ایمیل">
                                    <i class="fa fa-envelope"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-span-12 sm:col-span-6 md:col-span-6 lg:col-span-2 mb-4">
                    <div class="footer-section">
                        <h4
                            class="footer-title text-lg font-bold text-white mb-5 pb-3 border-b-2 border-green-500 inline-block relative">
                            <span class="absolute bottom-[-2px] right-0 w-2/5 h-0.5 bg-emerald-400"></span>
                            دسترسی سریع
                        </h4>
                        <ul class="footer-links list-none p-0 m-0">
                            <li class="mb-3">
                                <a href="{{ route('home') }}"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>خانه</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>محصولات</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>سوالات متداول</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>اخبار</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>مقالات</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-span-12 sm:col-span-6 md:col-span-6 lg:col-span-2 mb-4">
                    <div class="footer-section">
                        <h4
                            class="footer-title text-lg font-bold text-white mb-5 pb-3 border-b-2 border-green-500 inline-block relative">
                            <span class="absolute bottom-[-2px] right-0 w-2/5 h-0.5 bg-emerald-400"></span>
                            خدمات ما
                        </h4>
                        <ul class="footer-links list-none p-0 m-0">
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>صادرات</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>واردات</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>ترخیص کالا</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>قوانین</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-chevron-left text-xs transition-transform duration-300"></i>
                                    <span>درباره ما</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Related Links -->
                <div class="col-span-12 sm:col-span-6 md:col-span-6 lg:col-span-2 mb-4">
                    <div class="footer-section">
                        <h4
                            class="footer-title text-lg font-bold text-white mb-5 pb-3 border-b-2 border-green-500 inline-block relative">
                            <span class="absolute bottom-[-2px] right-0 w-2/5 h-0.5 bg-emerald-400"></span>
                            لینک های مفید
                        </h4>
                        <ul class="footer-links list-none p-0 m-0">
                            <li class="mb-3">
                                <a href="#" target="_blank"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-external-link text-xs transition-transform duration-300"></i>
                                    <span>لیست قیمت روزانه محصولات کیمیا تجارت زرK.T.Z</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" target="_blank"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-external-link text-xs transition-transform duration-300"></i>
                                    <span>سامانه پیامکی غلات</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" target="_blank"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-external-link text-xs transition-transform duration-300"></i>
                                    <span>سامانه قیمت بذر محصولات کشاورزی</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" target="_blank"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-external-link text-xs transition-transform duration-300"></i>
                                    <span>سامانه قیمت حبوبات</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" target="_blank"
                                    class="text-gray-300 no-underline text-sm transition-all duration-300 inline-flex items-center gap-2 hover:text-green-500 hover:-translate-x-1.25">
                                    <i class="fa fa-external-link text-xs transition-transform duration-300"></i>
                                    <span>سامانه قیمت نهاده و غلات</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tags -->
                <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-3 mb-4">
                    <div class="footer-section">
                        <h4
                            class="footer-title text-lg font-bold text-white mb-5 pb-3 border-b-2 border-green-500 inline-block relative">
                            <span class="absolute bottom-[-2px] right-0 w-2/5 h-0.5 bg-emerald-400"></span>
                            برچسب‌ها
                        </h4>
                        <div class="footer-tags-modern flex flex-wrap gap-2">
                            @forelse($tags as $tag)
                                <a href="#"
                                    class="footer-tag-item inline-block px-3 py-1.5 text-xs text-gray-300 bg-white/10 rounded-lg border border-white/20 transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-green-500 hover:-translate-y-0.5 hover:shadow-[0_2px_8px_rgba(40,167,69,0.3)] no-underline">
                                    {{ $tag->title }}
                                </a>
                            @empty
                                <p class="text-sm text-gray-400">برچسبی وجود ندارد</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom bg-black/30 py-5 border-t border-white/10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-center md:text-right mb-3 md:mb-0">
                    <p class="copyright-text text-sm text-gray-300 m-0">
                        © {{ date('Y') }} <strong class="text-green-500 font-bold">{{ $siteTitle }}</strong> - تمامی
                        حقوق محفوظ است
                    </p>
                </div>
                <div class="text-center md:text-left">
                    <p class="developer-text text-sm text-gray-300 m-0">
                        طراحی و توسعه با <i
                            class="fa fa-heart text-red-500 mx-1 animate-[heartbeat_1.5s_ease-in-out_infinite]"></i>
                        توسط تیم کیمیازر
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>