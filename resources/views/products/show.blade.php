<x-layouts.app>
    <main>
        <section class="py-8 md:py-12">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <!-- Left Column - Main Content -->
                    <div class="lg:col-span-8">
                        <div class="space-y-6">
                            <!-- Product Title -->
                            <div class="single-blog-title">
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                            </div>

                            <!-- Price Chart Section -->
                            <div class="price-chart-section mb-6 bg-white rounded-2xl shadow-md p-6">
                                <div
                                    class="chart-header flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                                    <h4 class="chart-title text-lg md:text-xl font-bold text-gray-900">نمودار تغییرات
                                        قیمت</h4>
                                    <div class="chart-range-selector flex gap-2 flex-wrap">
                                        <button
                                            class="range-btn active px-4 py-2 rounded-lg text-sm font-medium bg-gradient-to-r from-green-500 to-emerald-400 text-white hover:from-green-600 hover:to-emerald-500 transition-all duration-300"
                                            data-range="1m">۱ ماه</button>
                                        <button
                                            class="range-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-300"
                                            data-range="3m">۳ ماه</button>
                                        <button
                                            class="range-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-300"
                                            data-range="6m">۶ ماه</button>
                                        <button
                                            class="range-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-300"
                                            data-range="1y">۱ سال</button>
                                    </div>
                                </div>
                                <div class="chart-container w-full overflow-hidden relative" style="height: 400px;">
                                    <div id="chartLoading"
                                        class="chart-loading absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 z-10"
                                        style="display: none;">
                                        <div class="text-center">
                                            <i class="fa fa-spinner fa-spin text-2xl text-green-500 mb-2"></i>
                                            <p class="text-gray-600">در حال بارگذاری...</p>
                                        </div>
                                    </div>
                                    <canvas id="priceChart" height="400">لطفا مرورگر خود را به‌روزرسانی کنید تا نمودار
                                        قیمت نمایش داده شود.</canvas>
                                </div>
                            </div>

                            <!-- Price History Card -->
                            <div class="modern-price-history-card bg-white rounded-2xl shadow-md overflow-hidden">
                                <div
                                    class="price-history-header bg-gradient-to-r from-green-500 to-emerald-400 px-6 py-4 flex items-center gap-3">
                                    <div
                                        class="header-icon w-10 h-10 rounded-lg bg-white bg-opacity-20 flex items-center justify-center">
                                        <i class="fa fa-line-chart text-white text-lg"></i>
                                    </div>
                                    <h4 class="text-lg md:text-xl font-bold text-white">تاریخچه تغییرات قیمت</h4>
                                </div>

                                <div class="price-history-list divide-y divide-gray-100">
                                    @php
                                        $today = now()->startOfDay();
                                        $latestPrice = $priceHistory->first();
                                    @endphp
                                    @forelse($priceHistory as $index => $price)
                                        @php
                                            $priceDate = $price->created_at->startOfDay();
                                            $isToday = $priceDate->equalTo($today);
                                            $isUnavailable = false; // You can add logic to check if price is unavailable
                                            $prevPrice = $priceHistory->get($index + 1);
                                            $changeType = 'stable';
                                            if ($prevPrice) {
                                                if ($price->price > $prevPrice->price) {
                                                    $changeType = 'increase';
                                                } elseif ($price->price < $prevPrice->price) {
                                                    $changeType = 'decrease';
                                                }
                                            }
                                        @endphp
                                        <div
                                            class="price-history-item {{ $isToday ? 'latest' : '' }} {{ $isUnavailable ? 'unavailable' : '' }} p-4 hover:bg-gray-50 transition-colors duration-200">
                                            <div
                                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                                <div class="item-date flex items-center gap-2 text-gray-600">
                                                    <i class="fa fa-calendar-o text-green-500"></i>
                                                    <span
                                                        class="text-sm md:text-base">{{ $price->created_at->format('Y/m/d') }}</span>
                                                </div>
                                                <div class="item-price flex items-center gap-2">
                                                    @if($isUnavailable)
                                                        <span class="price-unavailable text-gray-500 text-sm md:text-base">تماس
                                                            با هماهنگی</span>
                                                    @else
                                                        <span
                                                            class="price-value text-lg md:text-xl font-bold text-gray-900">{{ number_format($price->price, 0) }}</span>
                                                        <span class="price-unit text-sm text-gray-600">تومان</span>
                                                    @endif
                                                </div>
                                                <div class="item-change">
                                                    @if($isToday)
                                                        <span
                                                            class="change-badge today inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                            <i class="fa fa-star"></i> قیمت روز
                                                        </span>
                                                    @elseif($isUnavailable)
                                                        <span
                                                            class="change-badge neutral inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">—</span>
                                                    @else
                                                        <span
                                                            class="change-badge stable inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                            <i class="fa fa-minus"></i> ثابت
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center text-gray-500">
                                            <p>تاریخچه قیمت موجود نیست</p>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Product Body Section -->
                                @if($product->body)
                                    <div class="border-t border-gray-200">
                                        <div class="content-body p-6 prose max-w-none text-gray-700 leading-relaxed">
                                            {!! $product->body !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Sidebar -->
                    <div class="lg:col-span-4">
                        <div class="space-y-6 lg:sticky lg:top-6">
                            <!-- Product Gallery & Order Card -->
                            <div class="modern-product-order-card bg-white rounded-2xl shadow-md overflow-hidden">
                                <!-- Product Gallery -->
                                @if($product->photos->count() > 0)
                                    <div class="product-gallery-wrapper p-4">
                                        <div class="swiper product-gallery-swiper">
                                            <div class="swiper-wrapper">
                                                @foreach($product->photos as $photo)
                                                    <div class="swiper-slide">
                                                        <img src="{{ $photo->url }}" alt="{{ $product->name }}"
                                                            class="w-full h-auto rounded-lg object-cover">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if($product->photos->count() > 1)
                                                <div class="swiper-pagination"></div>
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Order Section -->
                                <div class="order-section p-6 border-t border-gray-100">
                                    <div class="order-header flex items-center gap-3 mb-4">
                                        <i class="fa fa-shopping-cart text-green-500 text-xl"></i>
                                        <h4 class="text-lg font-bold text-gray-900">ثبت سفارش</h4>
                                    </div>
                                    <div class="order-description mb-6">
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            در حال حاضر {{ $product->name }} جهت ثبت سفارش شرکت‌ها و اشخاص حقیقی در گروه
                                            بازرگانی کیمیا تجارت زر K.T.Z موجود میباشد. در صورت تمایل برای تکمیل و ثبت
                                            اطلاعات سفارش روی دکمه‌ی مربوط به سفارش مورد نظر کلیک نمایید.
                                        </p>
                                    </div>
                                    <div class="order-buttons space-y-3">
                                        <a class="modern-order-btn personal-order flex items-center gap-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl hover:from-green-100 hover:to-emerald-100 hover:border-green-300 transition-all duration-300 group"
                                            href="{{ route('orders.create.real', ['productSlug' => $product->slug]) }}">
                                            <div
                                                class="btn-icon w-12 h-12 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-300">
                                                <i class="fa fa-user text-lg"></i>
                                            </div>
                                            <div class="btn-content flex-1 text-right">
                                                <span class="btn-title block text-base font-bold text-gray-900">سفارش
                                                    حقیقی</span>
                                                <span class="btn-subtitle block text-sm text-gray-600">برای خریداران
                                                    شخصی</span>
                                            </div>
                                            <div
                                                class="btn-arrow text-green-500 group-hover:translate-x-1 transition-transform duration-300">
                                                <i class="fa fa-chevron-left"></i>
                                            </div>
                                        </a>
                                        <a class="modern-order-btn legal-order flex items-center gap-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl hover:from-green-100 hover:to-emerald-100 hover:border-green-300 transition-all duration-300 group"
                                            href="{{ route('orders.create.legal', ['productSlug' => $product->slug]) }}">
                                            <div
                                                class="btn-icon w-12 h-12 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-300">
                                                <i class="fa fa-building text-lg"></i>
                                            </div>
                                            <div class="btn-content flex-1 text-right">
                                                <span class="btn-title block text-base font-bold text-gray-900">سفارش
                                                    حقوقی</span>
                                                <span class="btn-subtitle block text-sm text-gray-600">برای شرکت‌ها و
                                                    سازمان‌ها</span>
                                            </div>
                                            <div
                                                class="btn-arrow text-green-500 group-hover:translate-x-1 transition-transform duration-300">
                                                <i class="fa fa-chevron-left"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic Banners -->
                            @if($banners->count() > 0)
                                <x-web.banner :banners="$banners" position="C" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @endpush

    @push('scripts')
        <!-- Swiper.js -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <!-- Product Chart (via Vite) -->
        @vite('resources/js/product-chart.js')
        <script>
            // Initialize product gallery swiper
            @if($product->photos->count() > 1)
                document.addEventListener('DOMContentLoaded', function () {
                    const productGallerySwiper = new Swiper('.product-gallery-swiper', {
                        slidesPerView: 1,
                        spaceBetween: 10,
                        loop: {{ $product->photos->count() > 1 ? 'true' : 'false' }},
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                });
            @endif

            // Initialize product price chart
            function initChart() {
                if (window.initProductPriceChart && window.Chart) {
                    window.initProductPriceChart({{ $product->id }}, @js($product->name));
                } else {
                    // Retry if Chart.js hasn't loaded yet
                    setTimeout(initChart, 100);
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initChart);
            } else {
                initChart();
            }
        </script>
    @endpush
</x-layouts.app>