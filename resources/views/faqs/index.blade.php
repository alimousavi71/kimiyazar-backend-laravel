@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp

<x-layouts.app title="سوالات متداول - {{ $siteTitle }}" dir="rtl">
    <x-web.page-banner title="سوالات متداول" />

    <main>
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    @if($faqs->count() > 0)
                        <div class="space-y-5">
                            @foreach($faqs as $index => $faq)
                                <div class="faq-item bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-green-200 group"
                                    id="faq-wrapper-{{ $index }}">
                                    <button
                                        class="faq-question w-full flex items-start gap-4 p-6 md:p-7 text-right cursor-pointer bg-transparent border-none outline-none transition-all duration-300 hover:bg-gradient-to-l hover:from-green-50 hover:to-transparent group/button"
                                        type="button" onclick="toggleFaq({{ $index }})" aria-expanded="false"
                                        aria-controls="faq-answer-{{ $index }}">
                                        
                                        <div class="faq-icon-wrapper flex-shrink-0 mt-1">
                                            <div
                                                class="faq-icon w-12 h-12 min-w-12 bg-gradient-to-br from-green-500 via-emerald-500 to-green-600 rounded-xl flex items-center justify-center text-white font-bold text-base shadow-[0_4px_15px_rgba(40,167,69,0.25)] transition-all duration-300 group-hover/button:scale-110 group-hover/button:shadow-[0_6px_20px_rgba(40,167,69,0.35)]">
                                                <i class="fas fa-question text-lg"></i>
                                            </div>
                                        </div>

                                        
                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="faq-question-text text-lg md:text-xl font-bold text-slate-800 mb-0 leading-relaxed group-hover/button:text-green-600 transition-colors duration-300">
                                                {{ $faq->question }}
                                            </h3>
                                        </div>

                                        
                                        <div class="flex-shrink-0 mt-1">
                                            <div
                                                class="faq-arrow-wrapper w-10 h-10 min-w-10 rounded-full bg-gray-100 flex items-center justify-center transition-all duration-300 group-hover/button:bg-green-100">
                                                <i class="fa fa-chevron-down faq-arrow text-green-600 text-sm transition-transform duration-300"
                                                    id="faq-arrow-{{ $index }}"></i>
                                            </div>
                                        </div>
                                    </button>

                                    
                                    <div class="faq-answer hidden overflow-hidden transition-all duration-300"
                                        id="faq-answer-{{ $index }}">
                                        <div class="px-6 md:px-7 pb-6 md:pb-7 pt-0">
                                            <div
                                                class="faq-answer-content pl-16 text-gray-700 leading-relaxed text-base md:text-lg border-r-4 border-green-200 pr-4 py-2">
                                                {!! nl2br(e($faq->answer)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-md p-12 text-center">
                            <div
                                class="w-20 h-20 mx-auto mb-5 bg-gradient-to-br from-green-50 to-emerald-50 rounded-full flex items-center justify-center shadow-[0_4px_15px_rgba(40,167,69,0.2)]">
                                <i class="fas fa-question-circle text-4xl text-green-500"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-2.5">سوالی یافت نشد</h3>
                            <p class="text-gray-600">در حال حاضر سوال متداولی برای نمایش وجود ندارد.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            function toggleFaq(index) {
                const answer = document.getElementById('faq-answer-' + index);
                const arrow = document.getElementById('faq-arrow-' + index);
                const button = arrow.closest('button');

                if (answer.classList.contains('hidden')) {
                    // Close all other FAQs
                    document.querySelectorAll('.faq-answer').forEach(function (item) {
                        if (item.id !== 'faq-answer-' + index) {
                            item.classList.add('hidden');
                            const itemIndex = item.id.split('-')[2];
                            const itemArrow = document.getElementById('faq-arrow-' + itemIndex);
                            if (itemArrow) {
                                itemArrow.classList.remove('rotate-180');
                            }
                            const itemButton = itemArrow?.closest('button');
                            if (itemButton) {
                                itemButton.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });

                    // Open this FAQ
                    answer.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                    button.setAttribute('aria-expanded', 'true');
                } else {
                    // Close this FAQ
                    answer.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                    button.setAttribute('aria-expanded', 'false');
                }
            }
        </script>
    @endpush
</x-layouts.app>