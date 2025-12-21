@props(['category'])

<div
    class="category-card-compact bg-white rounded-xl border border-gray-200 transition-all duration-300 h-full overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(40,167,69,0.12)] hover:border-green-200">
    <!-- Main Category Header -->
    <a href="#"
        class="category-main-link flex items-center gap-3 p-4 border-b border-gray-100 no-underline text-inherit hover:no-underline group">
        <div
            class="category-icon-compact w-10 h-10 min-w-10 bg-gray-100 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:bg-gradient-to-br group-hover:from-green-50 group-hover:to-emerald-50">
            <i
                class="fa fa-th-large text-gray-600 text-base transition-all duration-300 group-hover:text-green-500"></i>
        </div>
        <h3
            class="category-title-compact text-sm font-semibold text-slate-800 flex-1 line-clamp-2 transition-colors duration-300 group-hover:text-green-500">
            {{ $category->name }}
        </h3>
        <i
            class="fa fa-chevron-left category-main-arrow text-green-500 text-xs transition-all duration-300 group-hover:-translate-x-1"></i>
    </a>

    <!-- Subcategories -->
    @if($category->children && $category->children->count() > 0)
        <div class="subcategories-list p-3 flex flex-wrap gap-2">
            @foreach($category->children as $subcategory)
                <a href="#"
                    class="subcat-btn inline-block px-3 py-1.5 text-xs text-gray-700 bg-gray-50 rounded-lg border border-gray-200 transition-all duration-300 hover:bg-green-500 hover:text-white hover:border-green-500 hover:-translate-y-0.5 hover:shadow-[0_2px_8px_rgba(40,167,69,0.3)] no-underline">
                    {{ $subcategory->name }}
                </a>
            @endforeach
        </div>
    @endif
</div>