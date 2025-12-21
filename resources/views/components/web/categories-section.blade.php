@props(['categories' => collect()])

<section id="homepage-categories" class="py-5 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="section-header text-center mb-4">
            <h2 class="section-title text-2xl md:text-3xl font-bold text-slate-800 mb-2">دسته‌بندی محصولات</h2>
            <p class="section-subtitle text-sm md:text-base text-gray-600">
                محصولات خود را بر اساس دسته‌بندی مورد نظر کشف کنید
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($categories as $category)
                <div class="w-full mb-3">
                    <x-web.category-card :category="$category" />
                </div>
            @endforeach
        </div>
    </div>
</section>