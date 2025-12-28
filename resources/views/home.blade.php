<x-layouts.app title="{{ $settings['title'] ?? config('app.name') }}" dir="rtl">
    
    <x-web.slider :sliders="$sliders" />

    
    <x-web.banner position="A" :banners="$bannersA" />

    
    <x-web.products-section :products="$products" />

    
    <x-web.categories-section :categories="$rootCategories" />

    
    <x-web.services-section :services="$services" />

    
    <x-web.banner position="B" :banners="$bannersB" />

    
    <x-web.news-section :news="$news" />

    
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