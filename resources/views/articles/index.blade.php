@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="مقالات - {{ $siteTitle }}" dir="rtl">
    <x-web.page-banner title="مقالات" />

    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-9">
                        <!-- Articles List -->
                        <div class="space-y-6">
                            @forelse($articles as $item)
                                <article
                                    class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                                    <div class="flex flex-col md:flex-row">
                                        <!-- Article Image -->
                                        <div
                                            class="article-item-image md:w-80 flex-shrink-0 relative overflow-hidden bg-gray-100">
                                            <a href="#" class="block relative h-48 md:h-full">
                                                @if($item->photos->first())
                                                    <img src="{{ $item->photos->first()->url }}" alt="{{ $item->title }}"
                                                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                                        <i class="fas fa-file-alt text-4xl text-green-400"></i>
                                                    </div>
                                                @endif
                                                <div
                                                    class="article-item-overlay absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                                    <i
                                                        class="fa fa-arrow-left text-white text-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></i>
                                                </div>
                                            </a>
                                        </div>

                                        <!-- Article Details -->
                                        <div class="article-item-details flex-1 p-6">
                                            <div class="article-item-meta mb-3">
                                                <span
                                                    class="article-item-date inline-flex items-center gap-2 text-gray-500 text-sm">
                                                    <i class="fa fa-calendar text-green-500"></i>
                                                    {{ $item->created_at->format('Y/m/d') }}
                                                </span>
                                            </div>
                                            <h2
                                                class="article-item-title text-xl md:text-2xl font-bold text-slate-800 mb-3 hover:text-green-500 transition-colors duration-300">
                                                <a href="#" class="no-underline text-inherit hover:text-green-500">
                                                    {{ $item->title }}
                                                </a>
                                            </h2>
                                            <p
                                                class="article-item-excerpt text-gray-600 text-sm md:text-base leading-relaxed mb-4 line-clamp-3">
                                                {{ Str::limit(strip_tags($item->body ?? ''), 200) }}
                                            </p>
                                            <a class="article-item-read-more inline-flex items-center gap-2 text-green-500 font-semibold text-sm hover:text-emerald-600 transition-colors duration-300 no-underline"
                                                href="#">
                                                ادامه مطلب
                                                <i class="fa fa-arrow-left text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                                    <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-600 text-lg">هیچ مقاله‌ای یافت نشد.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($articles->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $articles->links('pagination::tailwind') }}
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-3">
                        <div class="space-y-6">
                            <!-- Search Widget -->
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <form method="get" action="{{ route('articles.index') }}" class="modern-search-box">
                                    <div class="flex gap-2">
                                        <input type="text" name="finder" value="{{ $search }}"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300"
                                            placeholder="جستجو در مقالات...">
                                        <button type="submit"
                                            class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-lg hover:from-green-600 hover:to-emerald-500 transition-all duration-300 shadow-md hover:shadow-lg">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Recent Articles Widget -->
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <h3
                                    class="widget-title text-xl font-bold text-slate-800 mb-4 pb-3 border-b border-gray-200">
                                    آخرین مقالات</h3>
                                <div class="recent-articles-list space-y-4">
                                    @forelse($recentArticles as $recentItem)
                                        <a href="#"
                                            class="recent-article-item flex gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-300 no-underline group">
                                            <div
                                                class="recent-article-thumb w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                                @if($recentItem->photos->first())
                                                    <img src="{{ $recentItem->photos->first()->url }}"
                                                        alt="{{ $recentItem->title }}"
                                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                                        <i class="fas fa-file-alt text-green-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="recent-article-info flex-1 min-w-0">
                                                <h5
                                                    class="text-sm font-semibold text-slate-800 mb-1 line-clamp-2 group-hover:text-green-500 transition-colors duration-300">
                                                    {{ $recentItem->title }}
                                                </h5>
                                                <span
                                                    class="recent-date inline-flex items-center gap-1 text-xs text-gray-500">
                                                    <i class="fa fa-clock-o"></i>
                                                    {{ $recentItem->created_at->format('Y/m/d') }}
                                                </span>
                                            </div>
                                        </a>
                                    @empty
                                        <p class="text-gray-500 text-sm">هیچ مقاله‌ای وجود ندارد.</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Tags Widget -->
                            @if($tags->count() > 0)
                                <div class="bg-white rounded-xl shadow-md p-6">
                                    <h3
                                        class="widget-title text-xl font-bold text-slate-800 mb-4 pb-3 border-b border-gray-200">
                                        برچسب‌ها</h3>
                                    <div class="tags-widget flex flex-wrap gap-2">
                                        @foreach($tags as $tag)
                                            <a href="#"
                                                class="tag-item inline-block px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-green-500 hover:text-white transition-all duration-300 no-underline">
                                                {{ $tag->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>