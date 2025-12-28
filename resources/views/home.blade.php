<x-layouts.app
    title="{{ $settings['title'] ?? config('app.name') }}"
    description="{{ $settings['description'] ?? 'کیمیازر - مرکز فروش و تامین مواد شیمیایی' }}"
    keywords="{{ $settings['keywords'] ?? 'شیمی، مواد شیمیایی، فروش شیمی' }}"
    canonical="{{ route('home') }}"
    ogTitle="{{ $settings['title'] ?? config('app.name') }}"
    ogDescription="{{ $settings['description'] ?? 'کیمیازر - مرکز فروش و تامین مواد شیمیایی' }}"
    :ogImage="asset('images/header_logo.png')"
    :ogUrl="route('home')"
    ogType="website"
    dir="rtl">
    
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