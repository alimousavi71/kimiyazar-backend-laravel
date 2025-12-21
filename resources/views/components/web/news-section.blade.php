@props(['news' => collect()])

@if($news->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-2">آخرین اخبار</h2>
                <p class="text-gray-600">از آخرین اخبار و رویدادها مطلع شوید</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($news as $item)
                    <div class="w-full">
                        <x-web.news-card :item="$item" />
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('news.index') }}"
                    class="inline-flex items-center gap-2.5 px-7 py-3 bg-white text-green-500 no-underline rounded-lg border border-green-200 font-semibold text-sm transition-all duration-300 shadow-sm hover:bg-green-500 hover:text-white hover:border-green-500 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(40,167,69,0.2)]">
                    <span>مشاهده همه اخبار</span>
                    <i class="fas fa-arrow-left text-xs transition-transform duration-300 group-hover:-translate-x-1"></i>
                </a>
            </div>
        </div>
    </section>
@endif