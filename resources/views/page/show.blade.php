@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="{{ $page->title }} - {{ $siteTitle }}" dir="rtl">
    <x-web.page-banner :title="$page->title" :breadcrumb="['صفحه', $page->title]" :breadcrumbRoutes="['home', null]" />

    <main>
        <section class="py-5 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <article class="bg-white rounded-xl shadow-md overflow-hidden">
                        <!-- Page Image -->
                        @if($page->photos->first())
                            <div class="w-full h-64 md:h-96 overflow-hidden bg-gray-100">
                                <img src="{{ $page->photos->first()->url }}" alt="{{ $page->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Page Content -->
                        <div class="p-6 md:p-8">
                            <!-- Meta Information -->
                            <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                                <span class="inline-flex items-center gap-2 text-gray-500 text-sm">
                                    <i class="fa fa-calendar text-green-500"></i>
                                    {{ $page->created_at->format('Y/m/d') }}
                                </span>
                                <span class="inline-flex items-center gap-2 text-gray-500 text-sm">
                                    <i class="fa fa-eye text-green-500"></i>
                                    {{ number_format($page->visit_count) }} بازدید
                                </span>
                            </div>

                            <!-- Title -->
                            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 mb-6">
                                {{ $page->title }}
                            </h1>

                            <!-- Body Content -->
                            @if($page->body)
                                <div class="content-body prose prose-lg max-w-none text-slate-700 leading-relaxed">
                                    {!! nl2br(e($page->body)) !!}
                                </div>
                            @else
                                <div class="text-center text-gray-500 py-8">
                                    <p>محتوایی برای نمایش وجود ندارد.</p>
                                </div>
                            @endif

                            <!-- Additional Photos -->
                            @if($page->photos->count() > 1)
                                <div class="mt-8 pt-8 border-t border-gray-200">
                                    <h3 class="text-xl font-bold text-slate-800 mb-4">تصاویر بیشتر</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($page->photos->skip(1) as $photo)
                                            <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
                                                <img src="{{ $photo->url }}" alt="{{ $page->title }}"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>