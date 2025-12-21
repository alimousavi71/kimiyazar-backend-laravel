@php
    $siteTitle = $settings['title'] ?? config('app.name');
@endphp
<x-layouts.app title="{{ $siteTitle }}" dir="rtl">
    <!-- Top Area -->
    <x-web.top-bar :settings="$settings" />

    <!-- Navigation -->
    <x-web.navigation />

    <!-- Hero Slider Section -->
    <x-web.slider :sliders="$sliders" />

    <!-- Banner Position A (Below Slider) -->
    <x-web.banner position="A" />

    <!-- Products Section -->
    <x-web.products-section :products="$products" />

    <!-- Categories Section -->
    <x-web.categories-section :categories="$rootCategories" />

    <!-- Services Section -->
    <x-web.services-section :services="$services" />

    <!-- Banner Position B (Middle of Home Page) -->
    <x-web.banner position="B" />

    <!-- News Section -->
    <x-web.news-section :news="$news" />

    <!-- Banner Position C (Top of Footer) -->
    <x-web.banner position="C" />

    <!-- Footer -->
    <x-web.footer />

    <!-- Scroll to Top Button -->
    <div class="fixed bottom-8 left-8 z-[999]">
        <a href="#"
            class="w-12.5 h-12.5 bg-gradient-to-br from-green-500 to-emerald-400 text-white flex items-center justify-center rounded-full no-underline text-lg shadow-[0_4px_15px_rgba(40,167,69,0.4)] border-3 border-white/20 transition-all duration-300 hover:-translate-y-1.25 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)]">
            <i class="fas fa-arrow-up animate-[bounceUp_2s_ease-in-out_infinite]"></i>
        </a>
    </div>

    @push('scripts')
        <script>
            // Mobile menu toggle
            document.addEventListener('DOMContentLoaded', function () {
                const toggle = document.getElementById('mobile-menu-toggle');
                const menu = document.getElementById('mobile-menu');

                if (toggle && menu) {
                    toggle.addEventListener('click', function () {
                        menu.classList.toggle('hidden');
                        const spans = toggle.querySelectorAll('span');
                        if (!menu.classList.contains('hidden')) {
                            spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                            spans[1].style.opacity = '0';
                            spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
                        } else {
                            spans[0].style.transform = '';
                            spans[1].style.opacity = '';
                            spans[2].style.transform = '';
                        }
                    });
                }

                // Search toggle
                const searchToggle = document.getElementById('search-toggle');
                const searchWrapper = document.getElementById('search-form-wrapper');

                if (searchToggle && searchWrapper) {
                    searchToggle.addEventListener('click', function () {
                        searchWrapper.classList.toggle('opacity-0');
                        searchWrapper.classList.toggle('invisible');
                        searchWrapper.classList.toggle('pointer-events-none');
                    });
                }

                // Category filter auto-submit
                const categoryFilter = document.getElementById('home-category-filter');
                if (categoryFilter) {
                    const hiddenSelect = categoryFilter.closest('.category-selector-wrapper')?.querySelector('select');
                    if (hiddenSelect) {
                        hiddenSelect.addEventListener('change', function () {
                            document.getElementById('product-filter-form').submit();
                        });
                    }
                }
            });
        </script>
        @vite(['resources/js/category-selector.js'])
    @endpush

    <style>
        @keyframes gradient {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        @keyframes bounceUp {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }
    </style>
</x-layouts.app>