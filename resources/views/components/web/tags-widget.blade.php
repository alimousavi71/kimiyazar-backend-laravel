@props([
    'tags' => collect(),
    'title' => 'برچسب‌ها',
    'emptyMessage' => 'برچسبی وجود ندارد',
])

@if($tags->count() > 0)
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="widget-title text-xl font-bold text-slate-800 mb-4 pb-3 border-b border-gray-200">
            {{ $title }}
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
@elseif($emptyMessage)
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="widget-title text-xl font-bold text-slate-800 mb-4 pb-3 border-b border-gray-200">
            {{ $title }}
        </h3>
        <p class="text-gray-500 text-sm">{{ $emptyMessage }}</p>
    </div>
@endif
