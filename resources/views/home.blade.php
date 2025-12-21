@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp
<x-layouts.app title="{{ $siteTitle }}" dir="rtl">
    <!-- Top Area -->
    <div class="bg-gradient-to-b from-slate-800 to-slate-900 py-2 border-b-4 border-green-500 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-green-500 via-emerald-400 to-green-500 bg-[length:200%_100%] animate-[gradient_3s_ease_infinite]"></div>
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="transition-all duration-300 hover:scale-105 hover:drop-shadow-[0_0_8px_rgba(40,167,69,0.6)]">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-11 w-auto object-contain brightness-0 invert" onerror="this.style.display='none'">
                    </a>
                </div>

                <!-- Contact Area -->
                <div class="flex flex-wrap items-center justify-center gap-4">
                    @if($settings['tel'] ?? null)
                        <a href="tel:{{ $settings['tel'] }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-gray-300 text-sm font-medium rounded-full border border-white/10 bg-white/5 transition-all duration-300 hover:text-white hover:bg-green-500 hover:border-emerald-400 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(40,167,69,0.4)]">
                            <i class="fas fa-phone text-green-500 text-sm transition-all duration-300 group-hover:text-white"></i>
                            <span>{{ $settings['tel'] }}</span>
                        </a>
                    @endif
                    @if($settings['mobile'] ?? null)
                        <a href="tel:{{ $settings['mobile'] }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-gray-300 text-sm font-medium rounded-full border border-white/10 bg-white/5 transition-all duration-300 hover:text-white hover:bg-green-500 hover:border-emerald-400 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(40,167,69,0.4)]">
                            <i class="fas fa-mobile-alt text-green-500 text-sm transition-all duration-300 group-hover:text-white"></i>
                            <span>{{ $settings['mobile'] }}</span>
                        </a>
                    @endif
                </div>

                <!-- Language Selector & Get Quote -->
                <div class="flex items-center justify-end gap-3">
                    <div class="flex gap-2 items-center">
                        <a href="#" class="inline-block transition-all duration-300 rounded-md overflow-hidden border-2 border-white/20 opacity-70 hover:border-green-500 hover:-translate-y-1 hover:scale-110 hover:shadow-[0_4px_12px_rgba(40,167,69,0.5)] hover:opacity-100">
                            <img src="{{ asset('images/flags/en.png') }}" alt="English" class="w-7 h-5 object-cover block" onerror="this.style.display='none'">
                        </a>
                        <a href="#" class="inline-block transition-all duration-300 rounded-md overflow-hidden border-2 border-green-500 shadow-[0_0_12px_rgba(40,167,69,0.6)] opacity-100">
                            <img src="{{ asset('images/flags/fa.png') }}" alt="فارسی" class="w-7 h-5 object-cover block" onerror="this.style.display='none'">
                        </a>
                    </div>
                    <a href="#" class="px-4 py-1.5 text-sm font-semibold rounded-full border-2 border-green-500 bg-gradient-to-r from-green-500 to-emerald-400 text-white transition-all duration-300 shadow-[0_2px_10px_rgba(40,167,69,0.3)] hover:-translate-y-1 hover:scale-105 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)] hover:from-emerald-400 hover:to-green-500">
                        استعلام قیمت
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-[0_2px_15px_rgba(0,0,0,0.08)] sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center justify-between py-0">
                <!-- Mobile Logo & Toggle -->
                <div class="lg:hidden flex items-center justify-between w-full py-2.5">
                    <div class="flex-1">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto" onerror="this.style.display='none'">
                        </a>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex gap-1.5 items-center">
                            <a href="#" class="inline-block rounded border-2 border-gray-200 transition-all duration-300 hover:border-green-500 hover:-translate-y-0.5 hover:shadow-[0_2px_8px_rgba(40,167,69,0.3)]">
                                <img src="{{ asset('images/flags/en.png') }}" alt="English" class="w-6.5 h-4.5 object-cover block" onerror="this.style.display='none'">
                            </a>
                            <a href="#" class="inline-block rounded border-2 border-green-500 transition-all duration-300">
                                <img src="{{ asset('images/flags/fa.png') }}" alt="فارسی" class="w-6.5 h-4 object-cover block" onerror="this.style.display='none'">
                            </a>
                        </div>
                        <button type="button" class="flex flex-col justify-around w-7.5 h-6.25 bg-transparent border-none cursor-pointer p-0 z-10" id="mobile-menu-toggle">
                            <span class="w-full h-0.75 bg-green-500 rounded-full transition-all duration-300 origin-center"></span>
                            <span class="w-full h-0.75 bg-green-500 rounded-full transition-all duration-300 origin-center"></span>
                            <span class="w-full h-0.75 bg-green-500 rounded-full transition-all duration-300 origin-center"></span>
                        </button>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden lg:flex items-center gap-1.25 w-full" id="nav-menu">
                    <ul class="flex items-center gap-1.25 m-0 p-0 list-none w-full">
                        <li class="relative">
                            <a href="{{ route('home') }}" class="flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-15 font-medium transition-all duration-300 relative">
                                <i class="fas fa-home text-green-500 text-base transition-all duration-300"></i>
                                <span>خانه</span>
                                <span class="absolute bottom-0 right-1/2 w-0 h-0.75 bg-gradient-to-r from-green-500 to-emerald-400 transition-all duration-300 translate-x-1/2 rounded-t"></span>
                            </a>
                        </li>
                        <li class="relative">
                            <a href="#" class="flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-15 font-medium transition-all duration-300 relative">
                                <i class="fas fa-box text-green-500 text-base transition-all duration-300"></i>
                                <span>محصولات</span>
                                <span class="absolute bottom-0 right-1/2 w-0 h-0.75 bg-gradient-to-r from-green-500 to-emerald-400 transition-all duration-300 translate-x-1/2 rounded-t"></span>
                            </a>
                        </li>
                        <li class="relative">
                            <a href="#" class="flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-15 font-medium transition-all duration-300 relative">
                                <i class="fas fa-newspaper text-green-500 text-base transition-all duration-300"></i>
                                <span>اخبار</span>
                                <span class="absolute bottom-0 right-1/2 w-0 h-0.75 bg-gradient-to-r from-green-500 to-emerald-400 transition-all duration-300 translate-x-1/2 rounded-t"></span>
                            </a>
                        </li>
                        <li class="relative">
                            <a href="#" class="flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-15 font-medium transition-all duration-300 relative">
                                <i class="fas fa-info-circle text-green-500 text-base transition-all duration-300"></i>
                                <span>درباره ما</span>
                                <span class="absolute bottom-0 right-1/2 w-0 h-0.75 bg-gradient-to-r from-green-500 to-emerald-400 transition-all duration-300 translate-x-1/2 rounded-t"></span>
                            </a>
                        </li>
                        <li class="relative">
                            <a href="#" class="flex items-center gap-2 py-5 px-4 text-slate-700 no-underline text-15 font-medium transition-all duration-300 relative">
                                <i class="fas fa-envelope text-green-500 text-base transition-all duration-300"></i>
                                <span>تماس با ما</span>
                                <span class="absolute bottom-0 right-1/2 w-0 h-0.75 bg-gradient-to-r from-green-500 to-emerald-400 transition-all duration-300 translate-x-1/2 rounded-t"></span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Navbar Actions -->
                <div class="hidden lg:flex items-center gap-3 mr-5">
                    <!-- Search -->
                    <div class="relative z-100">
                        <button type="button" class="w-10.5 h-10.5 bg-transparent border-2 border-gray-200 rounded-full flex items-center justify-center text-slate-700 cursor-pointer transition-all duration-300 text-base hover:bg-green-500 hover:border-green-500 hover:text-white hover:rotate-90" id="search-toggle">
                            <i class="fas fa-search"></i>
                        </button>
                        <div class="absolute top-[120%] left-1/2 transform -translate-x-1/2 w-80 opacity-0 invisible transition-opacity duration-300 z-1001 pointer-events-none" id="search-form-wrapper">
                            <form class="flex bg-white rounded-3xl shadow-[0_8px_25px_rgba(0,0,0,0.15)] overflow-hidden border-2 border-green-500">
                                <input type="text" class="flex-1 px-5 py-3 border-none outline-none text-sm font-['IRANSans',sans-serif] rtl" placeholder="جستجو..." dir="rtl" id="search-input">
                                <button type="submit" class="w-12.5 bg-green-500 border-none text-white cursor-pointer transition-all duration-300 text-base hover:bg-emerald-400">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <a href="#" class="inline-flex items-center gap-2 px-4.5 py-2.5 rounded-full no-underline text-sm font-semibold transition-all duration-300 whitespace-nowrap bg-gradient-to-r from-green-500 to-emerald-400 text-white border-2 border-transparent hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(40,167,69,0.4)]">
                        استعلام قیمت
                    </a>
                    <a href="#" class="inline-flex items-center gap-2 px-4.5 py-2.5 rounded-full no-underline text-sm font-semibold transition-all duration-300 whitespace-nowrap bg-transparent text-green-500 border-2 border-green-500 hover:bg-green-500 hover:text-white hover:-translate-y-0.5 hover:shadow-[0_4px_15px_rgba(40,167,69,0.3)]">
                        <i class="fas fa-user"></i>
                        <span>حساب کاربری</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="lg:hidden w-full mt-2.5 bg-white rounded-lg p-2.5 shadow-[0_2px_8px_rgba(0,0,0,0.08)] hidden" id="mobile-menu">
                <ul class="flex flex-col w-full gap-0">
                    <li class="w-full">
                        <a href="{{ route('home') }}" class="py-3 px-4 justify-start text-sm block no-underline">خانه</a>
                    </li>
                    <li class="w-full">
                        <a href="#" class="py-3 px-4 justify-start text-sm block no-underline">محصولات</a>
                    </li>
                    <li class="w-full">
                        <a href="#" class="py-3 px-4 justify-start text-sm block no-underline">اخبار</a>
                    </li>
                    <li class="w-full">
                        <a href="#" class="py-3 px-4 justify-start text-sm block no-underline">درباره ما</a>
                    </li>
                    <li class="w-full">
                        <a href="#" class="py-3 px-4 justify-start text-sm block no-underline">تماس با ما</a>
                    </li>
                </ul>
                <div class="flex flex-col w-full gap-2 mt-2.5 pt-2.5 border-t border-gray-200 px-4 pb-2.5">
                    <form class="w-full">
                        <div class="flex gap-0 border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 focus-within:border-green-500 focus-within:shadow-[0_0_0_3px_rgba(40,167,69,0.1)]">
                            <input type="text" class="flex-1 px-4 py-2.5 border-none outline-none text-sm rtl pointer-events-auto" placeholder="جستجو..." dir="rtl">
                            <button type="submit" class="border-none bg-green-500 text-white cursor-pointer px-4 py-2.5 transition-all duration-300 hover:bg-emerald-400 pointer-events-auto">
                                <i class="fas fa-search text-sm"></i>
                            </button>
                        </div>
                    </form>
                    <a href="#" class="w-full justify-center px-4 py-2.5 text-sm no-underline">استعلام قیمت</a>
                    <a href="#" class="w-full justify-center px-4 py-2.5 text-sm no-underline">حساب کاربری</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Slider Section -->
    @if($sliders->count() > 0)
        <section class="relative bg-gray-100">
            <div class="container mx-auto px-4 py-8">
                <div class="grid grid-cols-1 md:grid-cols-{{ min($sliders->count(), 3) }} gap-6">
                    @foreach($sliders->take(3) as $slider)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 shadow-sm hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.08)] hover:border-green-200">
                            @if($slider->primaryPhoto())
                                <div class="relative w-full pt-[65%] overflow-hidden bg-gray-100">
                                    <img src="{{ $slider->primaryPhoto()->url }}" alt="{{ $slider->title }}" class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-400 group-hover:scale-105">
                                </div>
                            @endif
                            <div class="p-5">
                                @if($slider->heading)
                                    <div class="absolute top-3 right-3 bg-gradient-to-r from-green-500 to-emerald-400 text-white px-3 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5 shadow-[0_2px_8px_rgba(40,167,69,0.4)]">
                                        <i class="fas fa-calendar text-xs"></i>
                                        <span>{{ $slider->heading }}</span>
                                    </div>
                                @endif
                                <h3 class="text-base font-bold text-slate-800 mb-4 line-clamp-2 transition-colors duration-300 group-hover:text-green-500">{{ $slider->title }}</h3>
                                @if($slider->description)
                                    <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $slider->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Products Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-slate-800 mb-2">محصولات ما</h2>
                <p class="text-gray-600">بهترین محصولات با بهترین قیمت</p>
            </div>

            <!-- Filter Container -->
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 mb-6 shadow-sm border border-gray-200 border-r-4 border-r-green-500">
                <form method="GET" action="{{ route('home') }}" class="w-full" id="product-filter-form">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
                        <!-- Search Input -->
                        <div class="relative flex items-center w-full">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجو محصولات..." class="w-full h-11 px-4 pr-10 border-2 border-gray-200 rounded-lg text-sm font-inherit bg-white transition-all duration-300 text-gray-700 rtl text-right focus:outline-none focus:border-green-500 focus:shadow-[0_0_0_4px_rgba(40,167,69,0.1)] focus:bg-white" dir="rtl">
                            <i class="fas fa-search absolute right-3 text-gray-500 text-sm pointer-events-none z-2 transition-colors duration-300"></i>
                        </div>

                        <!-- Category Filter -->
                        <div class="relative">
                            <x-category-selector 
                                name="category_id" 
                                id="home-category-filter"
                                :value="request('category_id') ?: ''"
                                :categories="$categories"
                                :placeholder="__('admin/products.forms.placeholders.all_categories')"
                                class="w-full" />
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="h-11 px-6 bg-gradient-to-r from-green-500 to-emerald-400 text-white border-none rounded-lg text-sm font-semibold cursor-pointer transition-all duration-300 flex items-center gap-2 whitespace-nowrap shadow-[0_2px_4px_rgba(40,167,69,0.2)] hover:from-green-600 hover:to-emerald-500 hover:-translate-y-0.5 hover:shadow-[0_4px_8px_rgba(40,167,69,0.3)] active:translate-y-0 active:shadow-[0_1px_2px_rgba(40,167,69,0.2)]">
                            <i class="fas fa-search text-xs"></i>
                            <span>جستجو</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="products-container">
                @forelse($products as $product)
                    <div class="bg-white rounded-xl border border-gray-200 transition-all duration-300 h-full overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(40,167,69,0.12)] hover:border-green-200">
                        <a href="#" class="flex flex-col h-full no-underline text-inherit hover:no-underline">
                            <!-- Product Header -->
                            <div class="flex items-center gap-2.5 p-3.5 pb-2.5 border-b border-gray-100">
                                <div class="w-8 h-8 min-w-8 bg-gray-100 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:bg-gradient-to-br group-hover:from-green-50 group-hover:to-emerald-50">
                                    <i class="fas fa-box text-gray-600 text-base transition-all duration-300 group-hover:text-green-500"></i>
                                </div>
                                <div class="flex items-center justify-between flex-1 gap-2 min-w-0">
                                    <span class="text-xs text-gray-600 whitespace-nowrap overflow-hidden text-ellipsis flex-1">{{ $product->category?->name ?? 'بدون دسته‌بندی' }}</span>
                                    <span class="text-xs text-gray-400 flex items-center gap-1">
                                        <i class="fas fa-calendar text-xs"></i>
                                        <span>{{ $product->created_at->format('Y-m-d') }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Product Content -->
                            <div class="p-3.5 flex-1 min-h-[90px]">
                                <h3 class="text-15 font-semibold text-slate-800 mb-2 line-clamp-2 transition-colors duration-300 group-hover:text-green-500">{{ $product->name }}</h3>
                                @if($product->sale_description)
                                    <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">{{ Str::limit($product->sale_description, 100) }}</p>
                                @endif
                            </div>

                            <!-- Product Footer -->
                            <div class="flex items-center justify-between p-3.5 bg-gray-50 border-t border-gray-200">
                                <div class="flex items-baseline gap-1.25">
                                    @if($product->current_price)
                                        <span class="text-base font-bold text-green-500">{{ number_format($product->current_price) }}</span>
                                        <span class="text-xs text-gray-600">{{ $product->currency_code?->label() ?? '' }}</span>
                                    @else
                                        <span class="text-sm text-gray-400">قیمت نامشخص</span>
                                    @endif
                                </div>
                                <div class="w-7 h-7 bg-white rounded-full flex items-center justify-center transition-all duration-300 border border-gray-200 group-hover:bg-green-500 group-hover:border-green-500">
                                    <i class="fas fa-arrow-left text-green-500 text-xs transition-all duration-300 group-hover:text-white group-hover:-translate-x-0.5"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-5 bg-gradient-to-br from-green-50 to-emerald-50 rounded-full flex items-center justify-center shadow-[0_4px_15px_rgba(40,167,69,0.2)]">
                            <i class="fas fa-box-open text-4xl text-green-500"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2.5">محصولی یافت نشد</h3>
                        <p class="text-gray-600 mb-6">در حال حاضر محصولی برای نمایش وجود ندارد.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

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
