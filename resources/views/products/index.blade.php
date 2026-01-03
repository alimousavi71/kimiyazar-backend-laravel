@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="محصولات - {{ $siteTitle }}"
    description="مرکز فروش و تامین مواد شیمیایی صنعتی و آزمایشگاهی. محصولات باکیفیت با قیمت رقابتی"
    keywords="مواد شیمیایی، شیمی، فروش شیمی، تامین کننده شیمی" canonical="{{ route('products.index') }}"
    ogTitle="محصولات - {{ $siteTitle }}" ogDescription="مرکز فروش و تامین مواد شیمیایی صنعتی و آزمایشگاهی"
    :ogImage="asset('images/header_logo.png')" :ogUrl="route('products.index')" ogType="website" dir="rtl">
    <x-web.page-banner title="محصولات" />

    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">

                <div class="text-center mb-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">محصولات</h2>
                    <p class="text-gray-600 text-sm md:text-base">
                        آخرین بروزرسانی قیمت محصولات:
                        @if($latestPriceUpdate)
                            <span class="text-green-600 font-semibold">
                                <x-date :date="\Carbon\Carbon::parse($latestPriceUpdate)" type="datetime" />
                            </span>
                        @else
                            <span class="text-gray-400">اطلاعاتی موجود نیست</span>
                        @endif
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <div class="lg:col-span-3 sticky top-6 self-start">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">

                            <div class="bg-green-500 px-4 py-3 flex items-center gap-2">
                                <i class="fa fa-list text-white"></i>
                                <h6 class="text-white font-semibold mb-0">دسته‌بندی محصولات</h6>
                            </div>


                            <div class="p-0">
                                <div class="category-filter">

                                    <div class="category-breadcrumb px-4 py-3 border-b border-gray-200 bg-gray-50">
                                        <div class="flex items-center gap-2 text-sm flex-wrap">
                                            <a href="{{ route('products.index') }}"
                                                class="flex items-center gap-1 text-gray-700 hover:text-green-600 transition-colors no-underline {{ !$categoryId ? 'text-green-600 font-semibold' : '' }}">
                                                <i class="fa fa-home"></i>
                                                <span>خانه</span>
                                            </a>
                                            @if($breadcrumbPath->isNotEmpty())
                                                @foreach($breadcrumbPath as $index => $breadcrumbCategory)
                                                    <i class="fa fa-angle-left text-gray-400 text-xs"></i>
                                                    @if($index === $breadcrumbPath->count() - 1)
                                                        <span
                                                            class="text-green-600 font-semibold">{{ $breadcrumbCategory->name }}</span>
                                                    @else
                                                        <a href="{{ route('products.index', ['category' => $breadcrumbCategory->id]) }}"
                                                            class="text-gray-700 hover:text-green-600 transition-colors no-underline">
                                                            {{ $breadcrumbCategory->name }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                <i class="fa fa-angle-left text-gray-400 text-xs"></i>
                                                <span class="text-green-600 font-semibold">همه دسته‌بندی‌ها</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="category-list-seo max-h-[600px] overflow-y-auto">
                                        @forelse($categoriesToShow as $category)
                                            <a href="{{ route('products.index', ['category' => $category->id]) }}"
                                                class="category-item-seo flex items-center justify-between px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 no-underline {{ $categoryId == $category->id ? 'bg-green-50 border-green-200' : '' }}">
                                                <div class="category-content flex items-center gap-3 flex-1 min-w-0">
                                                    <div
                                                        class="category-icon w-8 h-8 flex items-center justify-center text-gray-500">
                                                        <i class="fa fa-folder-o"></i>
                                                    </div>
                                                    <div class="category-info flex-1 min-w-0">
                                                        <span
                                                            class="category-title text-sm text-gray-700 font-medium {{ $categoryId == $category->id ? 'text-green-600' : '' }}">
                                                            {{ $category->name }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <i class="fa fa-chevron-left text-gray-400 text-xs"></i>
                                            </a>
                                        @empty
                                            <div class="px-4 py-8 text-center text-gray-500 text-sm">
                                                <i class="fa fa-folder-open text-3xl mb-2 text-gray-300"></i>
                                                <p>زیردسته‌ای وجود ندارد</p>
                                                @if($currentCategory)
                                                    <p class="text-xs mt-1 text-gray-400">محصولات این دسته‌بندی در زیر نمایش
                                                        داده می‌شوند</p>
                                                @endif
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="lg:col-span-9">

                        <form method="GET" action="{{ route('products.index') }}" class="mb-6">
                            @if($categoryId)
                                <input type="hidden" name="category" value="{{ $categoryId }}">
                            @endif
                            <div class="bg-white rounded-xl shadow-md p-4">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                                    <div class="md:col-span-5">
                                        <div class="relative">
                                            <i
                                                class="fa fa-search absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                            <input name="search" type="text"
                                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300"
                                                placeholder="جستجوی محصولات..." value="{{ $search }}">
                                        </div>
                                    </div>
                                    <div class="md:col-span-4">
                                        <div class="relative">
                                            <i
                                                class="fa fa-sort-amount-desc absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                            <select name="sort"
                                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300 appearance-none bg-white">
                                                <option value="">مرتب‌سازی</option>
                                                <option value="product_price" {{ $sort === 'product_price' ? 'selected' : '' }}>قیمت (کم به زیاد)</option>
                                                <option value="price_date" {{ $sort === 'price_date' ? 'selected' : '' }}>
                                                    جدیدترین</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="md:col-span-3">
                                        <button type="submit"
                                            class="w-full px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-lg hover:from-green-600 hover:to-emerald-500 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                            <i class="fa fa-filter"></i>
                                            <span>اعمال فیلتر</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>


                        @if(!$categoryId && !$search && !$sort)
                            <div
                                class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 flex items-center gap-2 text-blue-700">
                                <i class="fa fa-info-circle"></i>
                                <span class="text-sm">نمایش 50 محصول اول. لطفا از فیلترها برای یافتن محصول مورد نظر استفاده
                                    کنید.</span>
                            </div>
                        @endif


                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                            @forelse($products as $product)
                                <x-web.product-card :product="$product" />
                            @empty
                                <div class="col-span-full bg-white rounded-xl shadow-md p-12 text-center">
                                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-600 text-lg">هیچ محصولی یافت نشد.</p>
                                </div>
                            @endforelse
                        </div>


                        @if($products->hasPages())
                            <div class="flex justify-center">
                                {{ $products->links('pagination::tailwind') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>