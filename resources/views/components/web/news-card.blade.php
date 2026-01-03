@props(['item'])

<div
    class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 shadow-sm hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(40,167,69,0.08)] hover:border-green-200 group">
    <a href="{{ $item->type->value === 'news' ? route('news.show', $item->slug) : route('articles.show', $item->slug) }}"
        class="flex flex-col h-full no-underline text-inherit hover:no-underline">
        <div class="relative w-full pt-[65%] overflow-hidden bg-gray-100">
            @if($item->photos->first())
                <img src="{{ $item->photos->first()->url }}" alt="{{ $item->title }}"
                    class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-400 group-hover:scale-105">
            @endif
            <div
                class="absolute top-3 right-3 bg-gradient-to-r from-green-500 to-emerald-400 text-white px-3 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5 shadow-[0_2px_8px_rgba(40,167,69,0.4)]">
                <i class="fas fa-calendar text-xs"></i>
                <span><x-date :date="$item->created_at" type="date" /></span>
            </div>
        </div>
        <div class="p-5 flex-1 flex flex-col min-h-[120px]">
            <h3
                class="text-base font-bold text-slate-800 mb-4 line-clamp-2 flex-1 transition-colors duration-300 group-hover:text-green-500">
                {{ $item->title }}
            </h3>
            <div class="mt-auto flex items-center justify-between">
                <span
                    class="inline-flex items-center gap-2 text-green-500 text-xs font-semibold transition-all duration-300 group-hover:gap-3 group-hover:text-emerald-400">
                    <span>ادامه مطلب</span>
                    <i class="fas fa-arrow-left text-xs transition-all duration-300 group-hover:-translate-x-1"></i>
                </span>
            </div>
        </div>
    </a>
</div>