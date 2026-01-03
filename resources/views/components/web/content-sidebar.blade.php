@props([
    'searchRoute' => '#',
    'searchPlaceholder' => 'جستجو...',
    'searchValue' => '',
    'recentItems' => collect(),
    'recentTitle' => 'آخرین مطالب',
    'emptyMessage' => 'هیچ مطلبی وجود ندارد.',
    'tags' => collect(),
    'icon' => 'fas fa-newspaper',
])

<div class="lg:col-span-3">
    <div class="space-y-6">
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <form method="get" action="{{ $searchRoute }}" class="modern-search-box">
                <div class="flex gap-2">
                    <input type="text" name="finder" value="{{ $searchValue }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300"
                        placeholder="{{ $searchPlaceholder }}">
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-lg hover:from-green-600 hover:to-emerald-500 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="widget-title text-xl font-bold text-slate-800 mb-4 pb-3 border-b border-gray-200">
                {{ $recentTitle }}
            </h3>
            <div class="recent-items-list space-y-4">
                @forelse($recentItems as $item)
                    <a href="{{ $item->type->value === 'news' ? route('news.show', $item->slug) : route('articles.show', $item->slug) }}"
                        class="recent-item flex gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-300 no-underline group">
                        <div class="recent-item-thumb w-20 h-20 shrink-0 rounded-lg overflow-hidden bg-gray-100">
                            @if($item->photos->first())
                                <img src="{{ $item->photos->first()->url }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                    <i class="{{ $icon }} text-green-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="recent-item-info flex-1 min-w-0">
                            <h5
                                class="text-sm font-semibold text-slate-800 mb-1 line-clamp-2 group-hover:text-green-500 transition-colors duration-300">
                                {{ $item->title }}
                            </h5>
                            <span class="recent-date inline-flex items-center gap-1 text-xs text-gray-500">
                                <i class="fa fa-clock-o"></i>
                                <x-date :date="$item->created_at" type="date" />
                            </span>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-sm">{{ $emptyMessage }}</p>
                @endforelse
            </div>
        </div>

        
        @if($tags->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="widget-title text-xl font-bold text-slate-800 mb-4 pb-3 border-b border-gray-200">
                    برچسب‌ها
                </h3>
                <div class="tags-widget flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <a href="{{ route('tags.index', $tag->slug) }}"
                            class="tag-item inline-block px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-green-500 hover:text-white transition-all duration-300 no-underline">
                            {{ $tag->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
