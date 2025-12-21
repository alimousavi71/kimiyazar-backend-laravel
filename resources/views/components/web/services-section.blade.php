@props(['services' => []])

<section id="service01" class="modern-services-section py-5 bg-white">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="section-header text-center mb-5">
            <h2 class="section-title text-2xl md:text-3xl font-bold text-slate-800 mb-2">خدمات ما</h2>
            <p class="section-subtitle text-sm md:text-base text-gray-600">
                خدمات ارائه شده توسط شرکت کیمیازر
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($services as $service)
                <div class="w-full">
                    <x-web.service-card :service="$service" />
                </div>
            @endforeach
        </div>
    </div>
</section>