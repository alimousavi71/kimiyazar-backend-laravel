@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app
    :title="$article->title . ' - ' . $siteTitle"
    :description="$article->seo_description ?? Str::limit(strip_tags($article->body), 160)"
    :keywords="$article->seo_keywords"
    :canonical="route('articles.show', $article->slug)"
    :ogTitle="$article->title"
    :ogDescription="$article->seo_description ?? Str::limit(strip_tags($article->body), 160)"
    :ogImage="$article->photos->first()?->url ?? asset('images/header_logo.png')"
    :ogUrl="route('articles.show', $article->slug)"
    ogType="article"
    dir="rtl">
    <x-web.page-banner :title="$article->title" :breadcrumb="['مقالات', $article->title]"
        :breadcrumbRoutes="['articles.index', null]" />

    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    <div class="lg:col-span-9">
                        <article class="bg-white rounded-xl shadow-md overflow-hidden">
                            
                            @if($article->photos->first())
                                <div class="w-full h-64 md:h-96 overflow-hidden bg-gray-100">
                                    <img src="{{ $article->photos->first()->url }}" alt="{{ $article->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endif

                            
                            <div class="p-6 md:p-8">
                                
                                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                                    <span class="inline-flex items-center gap-2 text-gray-500 text-sm">
                                        <i class="fa fa-calendar text-green-500"></i>
                                        {{ $article->created_at->format('Y/m/d') }}
                                    </span>
                                    <span class="inline-flex items-center gap-2 text-gray-500 text-sm">
                                        <i class="fa fa-eye text-green-500"></i>
                                        {{ number_format($article->visit_count) }} بازدید
                                    </span>
                                    @if($article->tags->count() > 0)
                                        <div class="flex flex-wrap items-center gap-2">
                                            <i class="fa fa-tags text-green-500 text-sm"></i>
                                            @foreach($article->tags->take(3) as $tag)
                                                <a href="{{ route('tags.index', $tag->slug) }}"
                                                    class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded hover:bg-green-500 hover:text-white transition-all duration-300 no-underline">
                                                    {{ $tag->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                
                                <h1 class="text-2xl md:text-3xl font-bold text-slate-800 mb-6">
                                    {{ $article->title }}
                                </h1>

                                
                                @if($article->body)
                                    <div class="content-body prose prose-lg max-w-none text-slate-700 leading-relaxed">
                                        {!! $article->body !!}
                                    </div>
                                @else
                                    <div class="text-center text-gray-500 py-8">
                                        <p>محتوایی برای نمایش وجود ندارد.</p>
                                    </div>
                                @endif

                                
                                @if($article->photos->count() > 1)
                                    <div class="mt-8 pt-8 border-t border-gray-200">
                                        <h3 class="text-xl font-bold text-slate-800 mb-4">تصاویر بیشتر</h3>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                            @foreach($article->photos->skip(1) as $photo)
                                                <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
                                                    <img src="{{ $photo->url }}" alt="{{ $article->title }}"
                                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </article>
                    </div>

                    
                    <x-web.content-sidebar :searchRoute="route('articles.index')" searchPlaceholder="جستجو در مقالات..."
                        searchValue="" :recentItems="$recentArticles" recentTitle="آخرین مقالات"
                        emptyMessage="هیچ مقاله‌ای وجود ندارد." :tags="$tags" icon="fas fa-file-alt" />
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>