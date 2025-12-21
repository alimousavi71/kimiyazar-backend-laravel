@props(['service'])

<div
    class="modern-service-card bg-white rounded-xl border border-gray-200 transition-all duration-300 overflow-hidden flex flex-col shadow-sm hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(40,167,69,0.12)] hover:border-green-200 h-full group">
    <div class="service-content p-6 flex-1 flex flex-col">
        <div class="service-icon-wrapper mb-5 text-center">
            <div
                class="w-16 h-16 mx-auto bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:from-green-100 group-hover:to-emerald-100">
                @if(isset($service['icon']) && $service['icon'])
                    <img src="{{ $service['icon'] }}" alt="{{ $service['title'] ?? '' }}" class="w-10 h-10 object-contain">
                @else
                    <i class="{{ $service['icon_class'] ?? 'fas fa-box' }} text-2xl text-green-500"></i>
                @endif
            </div>
        </div>

        <h3
            class="service-title text-xl font-bold text-slate-800 mb-3 leading-tight transition-colors duration-300 group-hover:text-green-600 text-center">
            {{ $service['title'] ?? 'خدمات' }}
        </h3>
        <p class="service-description text-sm text-slate-600 leading-relaxed text-center flex-1">
            {{ $service['description'] ?? '' }}
        </p>
    </div>
</div>