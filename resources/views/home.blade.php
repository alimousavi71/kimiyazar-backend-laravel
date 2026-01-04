<x-layouts.app
    title="{{ $settings['title'] ?? 'کیمیا تجارت زر - واردات و توزیع غلات و نهاده‌های دامی' }}"
    description="{{ $settings['description'] ?? 'کیمیا تجارت زر متخصص در واردات، تأمین و توزیع غلات و نهاده‌های دام، طیور و آبزیان از مبادی بین‌المللی. ترخیص کالا و مشاوره تخصصی تأمین نهاده‌های دامی.' }}"
    keywords="{{ $settings['keywords'] ?? 'واردات نهاده دامی، تامین غلات، نهاده دام و طیور، خوراک دام، ذرت دامی، جو دامی، کنجاله سویا، گلوتن ذرت، ترخیص کالا گمرکی' }}"
    canonical="{{ route('home') }}"
    ogTitle="{{ $settings['title'] ?? 'کیمیا تجارت زر - واردات و توزیع غلات و نهاده‌های دامی' }}"
    ogDescription="{{ $settings['description'] ?? 'تأمین پایدار و اقتصادی نهاده‌های دامی با دهه‌ها تجربه بازرگانی و شبکه تأمین بین‌المللی معتبر' }}"
    :ogImage="asset('images/header_logo.png')"
    :ogUrl="route('home')"
    ogType="website"
    dir="rtl">
    
    <x-web.slider :sliders="$sliders" />

    
    <x-web.banner position="A" :banners="$bannersA" />

    
    <x-web.categories-section :categories="$rootCategories" />
    
    
    <x-web.products-section :products="$products" />
   
    
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