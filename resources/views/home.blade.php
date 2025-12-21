<x-layouts.app title="{{ $settings['title'] ?? config('app.name') }}" dir="rtl">
    <!-- Hero Slider Section -->
    <x-web.slider :sliders="$sliders" />

    <!-- Banner Position A (Below Slider) -->
    <x-web.banner position="A" :banners="$bannersA" />

    <!-- Products Section -->
    <x-web.products-section :products="$products" />

    <!-- Categories Section -->
    <x-web.categories-section :categories="$rootCategories" />

    <!-- Services Section -->
    <x-web.services-section :services="$services" />

    <!-- Banner Position B (Middle of Home Page) -->
    <x-web.banner position="B" :banners="$bannersB" />

    <!-- News Section -->
    <x-web.news-section :news="$news" />

    <!-- Banner Position C (Top of Footer) -->
    <x-web.banner position="C" :banners="$bannersC" />

    @push('scripts')
        <script>
            // Category filter auto-submit (homepage specific)
            document.addEventListener('DOMContentLoaded', function () {
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
</x-layouts.app>