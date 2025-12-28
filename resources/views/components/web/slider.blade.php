@props(['sliders' => collect()])

@if($sliders->count() > 0)
    <section class="relative bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            
            <div class="swiper hero-slider rounded-xl overflow-hidden shadow-lg">
                <div class="swiper-wrapper">
                    @foreach($sliders->take(5) as $slider)
                        <div class="swiper-slide">
                            <div class="relative w-full h-[400px] md:h-[500px] lg:h-[600px] overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900">
                                @if($slider->primaryPhoto())
                                    <img src="{{ $slider->primaryPhoto()->url }}" 
                                         alt="{{ $slider->title }}" 
                                         class="absolute inset-0 w-full h-full object-cover opacity-90">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                                @else
                                    
                                    <div class="absolute inset-0 bg-gradient-to-br from-green-500 via-emerald-400 to-green-600"></div>
                                @endif
                                
                                
                                <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-10 lg:p-12 text-white z-10">
                                    @if($slider->heading)
                                        <div class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-400 text-white px-4 py-2 rounded-full text-xs md:text-sm font-semibold mb-4 shadow-[0_4px_12px_rgba(40,167,69,0.4)] w-fit">
                                            <i class="fas fa-calendar text-xs"></i>
                                            <span>{{ $slider->heading }}</span>
                                        </div>
                                    @endif
                                    
                                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3 md:mb-4 leading-tight drop-shadow-lg">
                                        {{ $slider->title }}
                                    </h2>
                                    
                                    @if($slider->description)
                                        <p class="text-sm md:text-base lg:text-lg text-gray-200 mb-4 md:mb-6 line-clamp-2 md:line-clamp-3 max-w-2xl drop-shadow-md">
                                            {{ $slider->description }}
                                        </p>
                                    @endif
                                    
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 md:px-6 md:py-3 bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-full text-sm md:text-base font-semibold transition-all duration-300 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)] hover:-translate-y-1 hover:scale-105">
                                            <span>اطلاعات بیشتر</span>
                                            <i class="fas fa-arrow-left text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                
                <div class="swiper-button-next !text-white !bg-green-500/80 hover:!bg-green-500 !w-12 !h-12 !rounded-full !shadow-lg !transition-all !duration-300 hover:!scale-110 after:!text-lg after:!font-bold"></div>
                <div class="swiper-button-prev !text-white !bg-green-500/80 hover:!bg-green-500 !w-12 !h-12 !rounded-full !shadow-lg !transition-all !duration-300 hover:!scale-110 after:!text-lg after:!font-bold"></div>
                
                
                <div class="swiper-pagination !bottom-4"></div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .hero-slider .swiper-pagination-bullet {
                background: #22c55e;
                opacity: 0.5;
                width: 12px;
                height: 12px;
                transition: all 0.3s;
            }
            
            .hero-slider .swiper-pagination-bullet-active {
                opacity: 1;
                background: #22c55e;
                width: 24px;
                border-radius: 6px;
            }
            
            .hero-slider .swiper-button-next,
            .hero-slider .swiper-button-prev {
                backdrop-filter: blur(10px);
            }
            
            .hero-slider .swiper-button-next:after,
            .hero-slider .swiper-button-prev:after {
                font-size: 18px;
            }
            
            @media (max-width: 768px) {
                .hero-slider .swiper-button-next,
                .hero-slider .swiper-button-prev {
                    display: none;
                }
            }
        </style>
    @endpush

    @push('scripts')
        @vite(['resources/js/slider.js'])
    @endpush
@endif
