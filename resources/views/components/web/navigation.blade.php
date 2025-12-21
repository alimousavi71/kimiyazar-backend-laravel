@php
    // Settings are automatically provided by SettingComposer for frontend views
    $settings = $settings ?? [];
    $siteTitle = $settings['title'] ?? config('app.name', 'Laravel');
@endphp

<header class="sticky top-0 z-50 bg-white shadow-[0_2px_15px_rgba(0,0,0,0.08)]">
    <div class="sticky-wrapper" style="height: auto;"></div>
    <nav class="navbar navbar-expand-lg">
        <div class="container mx-auto px-4">
            <!-- Mobile Logo & Toggle (only visible on mobile) -->
            <div class="lg:hidden flex items-center justify-between w-full py-3">
                <div class="mobile-logo">
                    <a href="{{ route('home') }}" title="{{ $siteTitle }}">
                        <!-- Simple White/Green Logo SVG -->
                        <svg class="h-8 w-auto" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="45" fill="#FFFFFF" stroke="#22C55E" stroke-width="4" />
                            <circle cx="50" cy="50" r="30" fill="#22C55E" />
                            <rect x="35" y="35" width="30" height="30" rx="5" fill="#FFFFFF" />
                        </svg>
                    </a>
                </div>
                <div class="mobile-actions flex items-center gap-3">
                    <div class="mobile-language-selector flex gap-1.5 items-center">
                        <a href="{{ route('home') }}" title="فارسی"
                            class="inline-block rounded border-2 border-green-500 transition-all duration-300">
                            <svg class="w-6 h-4 block" viewBox="0 0 28 20" xmlns="http://www.w3.org/2000/svg">
                                <rect width="28" height="6.67" fill="#239F40" />
                                <rect y="6.67" width="28" height="6.67" fill="#FFFFFF" />
                                <rect y="13.33" width="28" height="6.67" fill="#DA0000" />
                                <text x="14" y="12" font-size="8" fill="#DA0000" text-anchor="middle"
                                    font-weight="bold">☪</text>
                            </svg>
                        </a>
                        <a href="{{ route('home') }}?lang=en" title="English"
                            class="inline-block rounded border-2 border-gray-200 transition-all duration-300 hover:border-green-500">
                            <svg class="w-6 h-4 block" viewBox="0 0 28 20" xmlns="http://www.w3.org/2000/svg">
                                <rect width="28" height="20" fill="#012169" />
                                <path d="M0,0 L28,20 M28,0 L0,20" stroke="#FFFFFF" stroke-width="2" />
                                <path d="M0,0 L28,20 M28,0 L0,20" stroke="#C8102E" stroke-width="1.33" />
                                <path d="M14,0 L14,20 M0,10 L28,10" stroke="#FFFFFF" stroke-width="3.33" />
                                <path d="M14,0 L14,20 M0,10 L28,10" stroke="#C8102E" stroke-width="2" />
                            </svg>
                        </a>
                    </div>
                    <button
                        class="modern-navbar-toggler flex flex-col justify-around w-8 h-6 bg-transparent border-none cursor-pointer p-0"
                        type="button" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation"
                        id="mobile-menu-toggle">
                        <span class="w-full h-0.5 bg-green-500 rounded-full transition-all duration-300"></span>
                        <span class="w-full h-0.5 bg-green-500 rounded-full transition-all duration-300"></span>
                        <span class="w-full h-0.5 bg-green-500 rounded-full transition-all duration-300"></span>
                    </button>
                </div>
            </div>

            <!-- Navigation Menu (Desktop) -->
            <div class="hidden lg:flex lg:items-center lg:justify-between w-full py-2" id="navbarSupportedContent">
                <ul class="navbar-nav modern-nav-menu flex items-center gap-1 m-0 p-0 list-none flex-1">
                    <li class="nav-item">
                        <a class="nav-link flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-sm font-medium transition-all duration-300 hover:text-green-500"
                            href="{{ route('home') }}">
                            <i class="fas fa-home text-green-500 text-base"></i>
                            <span>خانه</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-sm font-medium transition-all duration-300 hover:text-green-500"
                            href="#">
                            <i class="fas fa-shopping-bag text-green-500 text-base"></i>
                            <span>محصولات</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown modern-dropdown relative group">
                        <a class="nav-link dropdown-toggle flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-sm font-medium transition-all duration-300 hover:text-green-500 cursor-pointer"
                            href="#" id="navbarDropdown2" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-briefcase text-green-500 text-base"></i>
                            <span>خدمات</span>
                            <i
                                class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-300 group-hover:rotate-180"></i>
                        </a>
                        <div class="dropdown-menu modern-dropdown-menu absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg min-w-[200px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2"
                            aria-labelledby="navbarDropdown2">
                            <a class="dropdown-item flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 no-underline hover:bg-green-50 hover:text-green-500 transition-colors duration-200"
                                href="#">
                                <i class="fas fa-plane text-green-500 text-sm"></i>
                                <span>صادرات</span>
                            </a>
                            <a class="dropdown-item flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 no-underline hover:bg-green-50 hover:text-green-500 transition-colors duration-200"
                                href="#">
                                <i class="fas fa-ship text-green-500 text-sm"></i>
                                <span>واردات</span>
                            </a>
                            <a class="dropdown-item flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 no-underline hover:bg-green-50 hover:text-green-500 transition-colors duration-200"
                                href="#">
                                <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                <span>ترخیص کالا</span>
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown modern-dropdown relative group">
                        <a class="nav-link dropdown-toggle flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-sm font-medium transition-all duration-300 hover:text-green-500 cursor-pointer"
                            href="#" id="navbarDropdown3" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-newspaper-o text-green-500 text-base"></i>
                            <span>اخبار</span>
                            <i
                                class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-300 group-hover:rotate-180"></i>
                        </a>
                        <div class="dropdown-menu modern-dropdown-menu absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg min-w-[200px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2"
                            aria-labelledby="navbarDropdown3">
                            <a class="dropdown-item flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 no-underline hover:bg-green-50 hover:text-green-500 transition-colors duration-200"
                                href="{{ route('news.index') }}">
                                <i class="fas fa-bullhorn text-green-500 text-sm"></i>
                                <span>اخبار</span>
                            </a>
                            <a class="dropdown-item flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 no-underline hover:bg-green-50 hover:text-green-500 transition-colors duration-200"
                                href="{{ route('articles.index') }}">
                                <i class="fas fa-file-text text-green-500 text-sm"></i>
                                <span>مقالات</span>
                            </a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-sm font-medium transition-all duration-300 hover:text-green-500"
                            href="{{ route('about.index') }}">
                            <i class="fas fa-info-circle text-green-500 text-base"></i>
                            <span>درباره ما</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-sm font-medium transition-all duration-300 hover:text-green-500"
                            href="{{ route('contact.index') }}">
                            <i class="fas fa-phone text-green-500 text-base"></i>
                            <span>تماس با ما</span>
                        </a>
                    </li>
                </ul>

                <!-- Action Buttons -->
                <div class="navbar-actions flex items-center gap-3 ml-5">
                    <!-- Search -->
                    <div class="search-wrapper relative">
                        <button
                            class="search-toggle-btn w-10 h-10 bg-transparent border-2 border-gray-200 rounded-full flex items-center justify-center text-slate-700 cursor-pointer transition-all duration-300 hover:bg-green-500 hover:border-green-500 hover:text-white hover:rotate-90"
                            type="button" id="search-toggle">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                        <div class="search-form-wrapper absolute top-[120%] left-1/2 transform -translate-x-1/2 w-80 opacity-0 invisible transition-opacity duration-300 z-50 pointer-events-none"
                            id="search-form-wrapper">
                            <form method="get" action="#"
                                class="modern-search-form flex bg-white rounded-3xl shadow-[0_8px_25px_rgba(0,0,0,0.15)] overflow-hidden border-2 border-green-500">
                                <input type="text" name="find" placeholder="جستجو در محصولات..."
                                    class="modern-search-input flex-1 px-5 py-3 border-none outline-none text-sm rtl"
                                    dir="rtl" id="search-input">
                                <button type="submit"
                                    class="modern-search-submit w-12 bg-green-500 border-none text-white cursor-pointer transition-all duration-300 hover:bg-emerald-400 flex items-center justify-center">
                                    <i class="fas fa-search text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Price Inquiry -->
                    <a href="#"
                        class="btn-inquiry inline-flex items-center gap-2 px-4 py-2.5 rounded-full no-underline text-sm font-semibold transition-all duration-300 whitespace-nowrap bg-gradient-to-r from-green-500 to-emerald-400 text-white border-2 border-transparent hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(40,167,69,0.4)]"
                        title="استعلام قیمت">
                        <i class="fas fa-calculator text-sm"></i>
                        <span>استعلام قیمت</span>
                    </a>

                    <!-- User Account -->
                    <a href="{{ route('auth.login') }}"
                        class="btn-login inline-flex items-center gap-2 px-4 py-2.5 rounded-full no-underline text-sm font-semibold transition-all duration-300 whitespace-nowrap bg-transparent text-green-500 border-2 border-green-500 hover:bg-green-500 hover:text-white hover:-translate-y-0.5 hover:shadow-[0_4px_15px_rgba(40,167,69,0.3)]"
                        title="ورود / ثبت نام">
                        <i class="fas fa-sign-in text-sm"></i>
                        <span>ورود</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu (Collapsible) -->
            <div class="lg:hidden w-full mt-2 bg-white rounded-lg p-3 shadow-[0_2px_8px_rgba(0,0,0,0.08)] hidden"
                id="mobile-menu">
                <ul class="flex flex-col w-full gap-0">
                    <li class="w-full">
                        <a href="{{ route('home') }}"
                            class="py-3 px-4 flex items-center gap-2 text-sm text-slate-700 no-underline hover:text-green-500 hover:bg-green-50 transition-colors duration-200 rounded">
                            <i class="fas fa-home text-green-500"></i>
                            <span>خانه</span>
                        </a>
                    </li>
                    <li class="w-full">
                        <a href="#"
                            class="py-3 px-4 flex items-center gap-2 text-sm text-slate-700 no-underline hover:text-green-500 hover:bg-green-50 transition-colors duration-200 rounded">
                            <i class="fas fa-shopping-bag text-green-500"></i>
                            <span>محصولات</span>
                        </a>
                    </li>
                    <li class="w-full">
                        <a href="#"
                            class="py-3 px-4 flex items-center gap-2 text-sm text-slate-700 no-underline hover:text-green-500 hover:bg-green-50 transition-colors duration-200 rounded">
                            <i class="fas fa-briefcase text-green-500"></i>
                            <span>خدمات</span>
                        </a>
                    </li>
                    <li class="w-full">
                        <a href="{{ route('news.index') }}"
                            class="py-3 px-4 flex items-center gap-2 text-sm text-slate-700 no-underline hover:text-green-500 hover:bg-green-50 transition-colors duration-200 rounded">
                            <i class="fas fa-newspaper-o text-green-500"></i>
                            <span>اخبار</span>
                        </a>
                    </li>
                    <li class="w-full">
                        <a href="{{ route('about.index') }}"
                            class="py-3 px-4 flex items-center gap-2 text-sm text-slate-700 no-underline hover:text-green-500 hover:bg-green-50 transition-colors duration-200 rounded">
                            <i class="fas fa-info-circle text-green-500"></i>
                            <span>درباره ما</span>
                        </a>
                    </li>
                    <li class="w-full">
                        <a href="{{ route('contact.index') }}"
                            class="py-3 px-4 flex items-center gap-2 text-sm text-slate-700 no-underline hover:text-green-500 hover:bg-green-50 transition-colors duration-200 rounded">
                            <i class="fas fa-phone text-green-500"></i>
                            <span>تماس با ما</span>
                        </a>
                    </li>
                </ul>
                <div class="flex flex-col w-full gap-2 mt-3 pt-3 border-t border-gray-200">
                    <form class="w-full" method="get" action="#">
                        <div
                            class="flex gap-0 border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 focus-within:border-green-500 focus-within:shadow-[0_0_0_3px_rgba(40,167,69,0.1)]">
                            <input type="text" name="find"
                                class="flex-1 px-4 py-2.5 border-none outline-none text-sm rtl"
                                placeholder="جستجو در محصولات..." dir="rtl">
                            <button type="submit"
                                class="border-none bg-green-500 text-white cursor-pointer px-4 py-2.5 transition-all duration-300 hover:bg-emerald-400 flex items-center justify-center">
                                <i class="fas fa-search text-sm"></i>
                            </button>
                        </div>
                    </form>
                    <a href="#"
                        class="w-full text-center px-4 py-2.5 text-sm font-semibold rounded-full bg-gradient-to-r from-green-500 to-emerald-400 text-white no-underline transition-all duration-300 hover:shadow-[0_4px_12px_rgba(40,167,69,0.3)]">
                        استعلام قیمت
                    </a>
                    <a href="{{ route('auth.login') }}"
                        class="w-full text-center px-4 py-2.5 text-sm font-semibold rounded-full bg-transparent text-green-500 border-2 border-green-500 no-underline transition-all duration-300 hover:bg-green-500 hover:text-white">
                        ورود / ثبت نام
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const isHidden = mobileMenu.classList.contains('hidden');

                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    mobileToggle.setAttribute('aria-expanded', 'true');

                    // Animate hamburger icon to X
                    const spans = mobileToggle.querySelectorAll('span');
                    if (spans.length >= 3) {
                        spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                        spans[0].style.transformOrigin = 'center';
                        spans[1].style.opacity = '0';
                        spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
                        spans[2].style.transformOrigin = 'center';
                    }
                } else {
                    mobileMenu.classList.add('hidden');
                    mobileToggle.setAttribute('aria-expanded', 'false');

                    // Reset hamburger icon
                    const spans = mobileToggle.querySelectorAll('span');
                    if (spans.length >= 3) {
                        spans[0].style.transform = '';
                        spans[1].style.opacity = '';
                        spans[2].style.transform = '';
                    }
                }
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function (e) {
                if (!mobileMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        mobileToggle.setAttribute('aria-expanded', 'false');

                        // Reset hamburger icon
                        const spans = mobileToggle.querySelectorAll('span');
                        if (spans.length >= 3) {
                            spans[0].style.transform = '';
                            spans[1].style.opacity = '';
                            spans[2].style.transform = '';
                        }
                    }
                }
            });
        }

        // Search toggle
        const searchToggle = document.getElementById('search-toggle');
        const searchWrapper = document.getElementById('search-form-wrapper');

        if (searchToggle && searchWrapper) {
            searchToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                searchWrapper.classList.toggle('opacity-0');
                searchWrapper.classList.toggle('invisible');
                searchWrapper.classList.toggle('pointer-events-none');
            });

            // Close search when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchWrapper.contains(e.target) && !searchToggle.contains(e.target)) {
                    searchWrapper.classList.add('opacity-0', 'invisible', 'pointer-events-none');
                }
            });
        }
    });
</script>