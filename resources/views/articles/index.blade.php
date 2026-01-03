@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="مقالات - {{ $siteTitle }}" description="بخش مقالات و نوشتارهای تخصصی در زمینه شیمی و مواد شیمیایی"
    keywords="مقالات شیمی، مقالات علمی، نوشتار شیمی" canonical="{{ route('articles.index') }}"
    ogTitle="مقالات - {{ $siteTitle }}" ogDescription="بخش مقالات و نوشتارهای تخصصی در زمینه شیمی و مواد شیمیایی"
    :ogImage="asset('images/header_logo.png')" :ogUrl="route('articles.index')" ogType="website" dir="rtl">
    <x-web.page-banner title="مقالات" />

    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <div class="lg:col-span-9">

                        <div class="space-y-6">
                            @forelse($articles as $item)
                                <article
                                    class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                                    <div class="flex flex-col md:flex-row">

                                        <div
                                            class="article-item-image md:w-80 flex-shrink-0 relative overflow-hidden bg-gray-100">
                                            <a href="{{ route('articles.show', $item->slug) }}"
                                                class="block relative h-48 md:h-full">
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


                                        <div class="article-item-details flex-1 p-6">
                                            <div class="article-item-meta mb-3">
                                                <span
                                                    class="article-item-date inline-flex items-center gap-2 text-gray-500 text-sm">
                                                    <i class="fa fa-calendar text-green-500"></i>
                                                    <x-date :date="$item->created_at" type="date" />
                                                </span>
                                            </div>
                                            <h2
                                                class="article-item-title text-xl md:text-2xl font-bold text-slate-800 mb-3 hover:text-green-500 transition-colors duration-300">
                                                <a href="{{ route('articles.show', $item->slug) }}"
                                                    class="no-underline text-inherit hover:text-green-500">
                                                    {{ $item->title }}
                                                </a>
                                            </h2>
                                            <p
                                                class="article-item-excerpt text-gray-600 text-sm md:text-base leading-relaxed mb-4 line-clamp-3">
                                                {{ Str::limit(strip_tags($item->body ?? ''), 200) }}
                                            </p>
                                            <a class="article-item-read-more inline-flex items-center gap-2 text-green-500 font-semibold text-sm hover:text-emerald-600 transition-colors duration-300 no-underline"
                                                href="{{ route('articles.show', $item->slug) }}">
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


                        @if($articles->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $articles->links('pagination::tailwind') }}
                            </div>
                        @endif
                    </div>


                    <x-web.content-sidebar :searchRoute="route('articles.index')" searchPlaceholder="جستجو در مقالات..."
                        :searchValue="$search" :recentItems="$recentArticles" recentTitle="آخرین مقالات"
                        emptyMessage="هیچ مقاله‌ای وجود ندارد." :tags="$tags" icon="fas fa-file-alt" />
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>