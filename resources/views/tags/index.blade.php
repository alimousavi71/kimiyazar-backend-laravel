@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="برچسب: {{ $tag->title }} - {{ $siteTitle }}" dir="rtl">
    <x-web.page-banner :title="'برچسب: ' . $tag->title" />

    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-9">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('tags.index', $tag->slug) }}" class="mb-6">
                            <div class="bg-white rounded-xl shadow-md p-4">
                                <div class="flex gap-2">
                                    <input type="text" name="search" value="{{ $search }}"
                                        class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300"
                                        placeholder="جستجو در مطالب این برچسب...">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-lg hover:from-green-600 hover:to-emerald-500 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                        <i class="fa fa-search"></i>
                                        <span>جستجو</span>
                                    </button>
                                    @if($search)
                                        <a href="{{ route('tags.index', $tag->slug) }}"
                                            class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300 flex items-center justify-center">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <!-- Results Info -->
                        <div class="mb-4 text-sm text-gray-600">
                            <span class="font-semibold text-slate-800">{{ $entities->total() }}</span>
                            <span>مطلب یافت شد</span>
                            @if($search)
                                <span>برای</span>
                                <span class="font-semibold text-green-600">"{{ $search }}"</span>
                            @endif
                        </div>

                        <!-- Entities List -->
                        <div class="space-y-6">
                            @forelse($entities as $item)
                                <article
                                    class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                                    <div class="flex flex-col md:flex-row">
                                        <!-- Entity Image -->
                                        <div
                                            class="entity-item-image md:w-80 flex-shrink-0 relative overflow-hidden bg-gray-100">
                                            @php
                                                $routeName = $item->type->value === 'news' ? 'news.show' : 'articles.show';
                                            @endphp
                                            <a href="{{ route($routeName, $item->slug) }}"
                                                class="block relative h-48 md:h-full">
                                                @if($item->photos->first())
                                                    <img src="{{ $item->photos->first()->url }}" alt="{{ $item->title }}"
                                                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                                        <i
                                                            class="{{ $item->type->value === 'news' ? 'fas fa-newspaper' : 'fas fa-file-alt' }} text-4xl text-green-400"></i>
                                                    </div>
                                                @endif
                                                <div
                                                    class="entity-item-overlay absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                                    <i
                                                        class="fa fa-arrow-left text-white text-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></i>
                                                </div>
                                            </a>
                                        </div>

                                        <!-- Entity Details -->
                                        <div class="entity-item-details flex-1 p-6">
                                            <div class="entity-item-meta mb-3 flex items-center gap-4 flex-wrap">
                                                <span
                                                    class="entity-item-type inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                                    <i
                                                        class="{{ $item->type->value === 'news' ? 'fas fa-newspaper' : 'fas fa-file-alt' }}"></i>
                                                    {{ $item->type->value === 'news' ? 'خبر' : 'مقاله' }}
                                                </span>
                                                <span
                                                    class="entity-item-date inline-flex items-center gap-2 text-gray-500 text-sm">
                                                    <i class="fa fa-calendar text-green-500"></i>
                                                    {{ $item->created_at->format('Y/m/d') }}
                                                </span>
                                                <span
                                                    class="entity-item-views inline-flex items-center gap-2 text-gray-500 text-sm">
                                                    <i class="fa fa-eye text-green-500"></i>
                                                    {{ number_format($item->visit_count ?? 0) }}
                                                </span>
                                            </div>
                                            <h2
                                                class="entity-item-title text-xl md:text-2xl font-bold text-slate-800 mb-3 hover:text-green-500 transition-colors duration-300">
                                                <a href="{{ route($routeName, $item->slug) }}"
                                                    class="no-underline text-inherit hover:text-green-500">
                                                    {{ $item->title }}
                                                </a>
                                            </h2>
                                            <p
                                                class="entity-item-excerpt text-gray-600 text-sm md:text-base leading-relaxed mb-4 line-clamp-3">
                                                {{ Str::limit(strip_tags($item->body ?? ''), 200) }}
                                            </p>
                                            <div class="flex items-center justify-between flex-wrap gap-3">
                                                <a class="entity-item-read-more inline-flex items-center gap-2 text-green-500 font-semibold text-sm hover:text-emerald-600 transition-colors duration-300 no-underline"
                                                    href="{{ route($routeName, $item->slug) }}">
                                                    ادامه مطلب
                                                    <i class="fa fa-arrow-left text-xs"></i>
                                                </a>
                                                @if($item->tags->count() > 0)
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <span class="text-gray-500 text-xs">برچسب‌ها:</span>
                                                        @foreach($item->tags->take(3) as $itemTag)
                                                            <a href="{{ route('tags.index', $itemTag->slug) }}"
                                                                class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded hover:bg-green-500 hover:text-white transition-all duration-300 no-underline">
                                                                {{ $itemTag->title }}
                                                            </a>
                                                        @endforeach
                                                        @if($item->tags->count() > 3)
                                                            <span
                                                                class="text-gray-400 text-xs">+{{ $item->tags->count() - 3 }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                                    <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-600 text-lg mb-2">هیچ مطلبی با این برچسب یافت نشد.</p>
                                    @if($search)
                                        <p class="text-gray-500 text-sm">لطفا عبارت جستجوی دیگری را امتحان کنید.</p>
                                    @endif
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($entities->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $entities->appends(request()->query())->links('pagination::tailwind') }}
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-4 pb-3 border-b border-gray-200">
                                اطلاعات برچسب
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 text-sm">نام برچسب:</span>
                                    <span class="font-semibold text-slate-800 block mt-1">{{ $tag->title }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 text-sm">تعداد مطالب:</span>
                                    <span
                                        class="font-semibold text-green-600 block mt-1">{{ $entities->total() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Related Tags -->
                        @if($relatedTags->count() > 0)
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <h3 class="text-xl font-bold text-slate-800 mb-4 pb-3 border-b border-gray-200">
                                    برچسب‌های مرتبط
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($relatedTags as $relatedTag)
                                        <a href="{{ route('tags.index', $relatedTag->slug) }}"
                                            class="inline-block px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-green-500 hover:text-white transition-all duration-300 no-underline">
                                            {{ $relatedTag->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>