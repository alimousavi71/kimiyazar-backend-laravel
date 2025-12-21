@props([
    'title' => '',
    'breadcrumb' => null, // If null, uses title. Can be string or array for multiple items
    'breadcrumbRoutes' => [], // Optional routes for breadcrumb items (array of route names or null)
])

@php
    // If breadcrumb is null, use title
    $breadcrumbText = $breadcrumb ?? $title;
    
    // If breadcrumb is an array, we'll handle multiple items
    $breadcrumbItems = is_array($breadcrumbText) ? $breadcrumbText : [$breadcrumbText];
    
    // Ensure breadcrumbRoutes is an array with same length
    if (!is_array($breadcrumbRoutes)) {
        $breadcrumbRoutes = [];
    }
@endphp

<!-- Page Banner Section -->
<div class="bg-gradient-to-b from-slate-800 to-slate-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $title }}</h1>
            <div class="flex items-center justify-center gap-2 text-sm md:text-base text-gray-300">
                <a href="{{ route('home') }}" class="hover:text-green-400 transition-colors duration-300">خانه</a>
                @foreach($breadcrumbItems as $index => $item)
                    <i class="fa fa-angle-left text-xs"></i>
                    @if(isset($breadcrumbRoutes[$index]) && $breadcrumbRoutes[$index])
                        <a href="{{ route($breadcrumbRoutes[$index]) }}" class="hover:text-green-400 transition-colors duration-300">{{ $item }}</a>
                    @else
                        <span class="text-green-400">{{ $item }}</span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
