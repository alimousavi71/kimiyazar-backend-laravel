@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app
    :title="$content->title . ' - ' . $siteTitle"
    :description="$content->seo_description ?? Str::limit(strip_tags($content->body), 160)"
    :keywords="$content->seo_keywords"
    :canonical="route('about.index')"
    :ogTitle="$content->title"
    :ogDescription="$content->seo_description ?? Str::limit(strip_tags($content->body), 160)"
    :ogImage="$content->photos->first()?->url ?? asset('images/header_logo.png')"
    :ogUrl="route('about.index')"
    ogType="website"
    dir="rtl">
    <x-web.page-banner :title="$content->title" />

    
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                    @if($content->body)
                        <div class="content-body prose prose-lg max-w-none text-slate-700 leading-relaxed">
                            {!! nl2br(e($content->body)) !!}
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <p>محتوایی برای نمایش وجود ندارد.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>