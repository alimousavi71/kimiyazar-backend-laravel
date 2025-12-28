@props(['product'])

<div
    class="modern-product-card bg-white rounded-xl border border-gray-200 transition-all duration-300 h-full overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(40,167,69,0.12)] hover:border-green-200">
    <a href="{{ route('products.show', $product->slug) }}"
        class="product-link-wrapper flex flex-col h-full no-underline text-inherit hover:no-underline">
        
        <div class="product-header flex items-center gap-2.5 p-3.5 pb-2.5 border-b border-gray-100">
            <div
                class="product-icon w-8 h-8 min-w-8 bg-gray-100 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-gradient-to-br hover:from-green-50 hover:to-emerald-50">
                <i class="fa fa-cube text-gray-600 text-base transition-all duration-300 hover:text-green-500"></i>
            </div>
            <div class="product-meta flex items-center justify-between flex-1 gap-2 min-w-0">
                <span
                    class="product-category text-xs text-gray-600 whitespace-nowrap overflow-hidden text-ellipsis flex-1">
                    {{ $product->category?->name ?? 'بدون دسته‌بندی' }}
                </span>
                <span class="product-date text-xs text-gray-400 flex items-center gap-1"
                    title="آخرین بروزرسانی: {{ $product->updated_at->timestamp }}">
                    <i class="fa fa-clock-o text-xs"></i>
                </span>
            </div>
        </div>

        
        <div class="product-content p-3.5 flex-1 min-h-[90px]">
            <h3
                class="product-title text-15 font-semibold text-slate-800 mb-2 line-clamp-2 transition-colors duration-300 hover:text-green-500">
                {{ $product->name }}
            </h3>
        </div>

        
        <div class="product-footer flex items-center justify-between p-3.5 bg-gray-50 border-t border-gray-200">
            <div class="price-section flex items-baseline gap-1.25">
                @if($product->current_price)
                    <span class="price-amount text-base font-bold text-green-500">
                        {{ number_format($product->current_price) }}
                    </span>
                    <span class="price-currency text-xs text-gray-600">
                        {{ $product->currency_code?->label() ?? 'تومان' }}
                    </span>
                @else
                    <span class="text-sm text-gray-400">قیمت نامشخص</span>
                @endif
            </div>
            <div
                class="action-arrow w-7 h-7 bg-white rounded-full flex items-center justify-center transition-all duration-300 border border-gray-200 hover:bg-green-500 hover:border-green-500">
                <i
                    class="fa fa-chevron-left text-green-500 text-xs transition-all duration-300 hover:text-white hover:-translate-x-0.5"></i>
            </div>
        </div>
    </a>
</div>