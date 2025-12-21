@props(['position' => 'A', 'banners' => collect()])

@php
    use App\Enums\Database\BannerPosition;

    // Map position letter to banner position enum values for config lookup
    $positionMap = [
        'A' => [BannerPosition::A1, BannerPosition::A2],
        'B' => [BannerPosition::B1, BannerPosition::B2],
        'C' => [BannerPosition::C1, BannerPosition::C2],
    ];

    // Get banner positions for this section
    $positions = $positionMap[$position] ?? [];

    // Get config dimensions for styling
    $config = config('banner.positions', []);
    $firstPosition = $positions[0] ?? null;
    $dimensions = $firstPosition ? ($config[$firstPosition->value] ?? ['width' => 1200, 'height' => 300]) : ['width' => 1200, 'height' => 300];

    // Standard height from config
    $standardHeight = $dimensions['height'];
@endphp

@if($banners->count() > 0)
    <section
        class="banner-section banner-position-{{ strtolower($position) }} py-6 {{ $position === 'C' ? 'bg-white' : 'bg-gray-50' }}">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 {{ $position === 'C' ? '' : 'md:grid-cols-2' }} gap-4">
                @foreach($banners as $banner)
                    <div
                        class="banner-item w-full overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        @if($banner->link)
                            <a href="{{ $banner->link }}" target="{{ str_starts_with($banner->link, 'http') ? '_blank' : '_self' }}"
                                rel="{{ str_starts_with($banner->link, 'http') ? 'noopener noreferrer' : '' }}"
                                class="block w-full h-full no-underline">
                                <img src="{{ asset('storage/' . $banner->banner_file) }}" alt="{{ $banner->name }}"
                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                    style="height: {{ $standardHeight }}px;">
                            </a>
                        @else
                            <div class="w-full h-full">
                                <img src="{{ asset('storage/' . $banner->banner_file) }}" alt="{{ $banner->name }}"
                                    class="w-full h-full object-cover" style="height: {{ $standardHeight }}px;">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif