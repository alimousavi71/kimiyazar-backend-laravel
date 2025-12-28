@props(['products' => collect()])

<section id="homepage-products" class="py-5 bg-white">
    <div class="container mx-auto px-4">
        
        <div class="section-header text-center mb-4">
            <h2 class="section-title text-2xl md:text-3xl font-bold text-slate-800 mb-2">جدیدترین محصولات</h2>
            <p class="section-subtitle text-sm md:text-base text-gray-600">
                آخرین بروزرسانی قیمت محصولات:
                <span class="update-date font-semibold text-green-600">
                    {{ now()->format('Y/m/d H:i') }}
                </span>
            </p>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 justify-items-center"
            id="products-container">
            @forelse($products as $product)
                <div class="w-full mb-3">
                    <x-web.product-card :product="$product" />
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div
                        class="w-20 h-20 mx-auto mb-5 bg-gradient-to-br from-green-50 to-emerald-50 rounded-full flex items-center justify-center shadow-[0_4px_15px_rgba(40,167,69,0.2)]">
                        <i class="fas fa-box-open text-4xl text-green-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2.5">محصولی یافت نشد</h3>
                    <p class="text-gray-600 mb-6">در حال حاضر محصولی برای نمایش وجود ندارد.</p>
                </div>
            @endforelse
        </div>

        
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}"
                class="btn-view-all-products inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-full text-sm md:text-base font-semibold transition-all duration-300 shadow-[0_2px_10px_rgba(40,167,69,0.3)] hover:-translate-y-1 hover:scale-105 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)] hover:from-emerald-400 hover:to-green-500 no-underline">
                <span>مشاهده همه محصولات</span>
                <i class="fa fa-chevron-left text-xs transition-transform duration-300 hover:-translate-x-1"></i>
            </a>
        </div>
    </div>
</section>