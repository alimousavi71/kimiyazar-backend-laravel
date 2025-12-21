@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="{{ $content->title }} - {{ $siteTitle }}" dir="rtl">
    <!-- Page Banner Section -->
    <div class="bg-gradient-to-b from-slate-800 to-slate-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $content->title }}</h1>
                <div class="flex items-center justify-center gap-2 text-sm md:text-base text-gray-300">
                    <a href="{{ route('home') }}" class="hover:text-green-400 transition-colors duration-300">خانه</a>
                    <i class="fa fa-angle-left text-xs"></i>
                    <span class="text-green-400">{{ $content->title }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
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