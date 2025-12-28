@php
    // Settings are automatically provided by SettingComposer for frontend views
    $settings = $settings ?? [];
@endphp

<div class="bg-gradient-to-b from-slate-800 to-slate-900 py-2 border-b-4 border-green-500 relative overflow-hidden">
    <div
        class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-green-500 via-emerald-400 to-green-500 bg-[length:200%_100%] animate-[gradient_3s_ease_infinite]">
    </div>
    <div class="container mx-auto px-3 sm:px-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-2 sm:gap-4">
            
            <div class="w-full sm:w-auto flex items-center justify-center sm:justify-start order-1 sm:order-1">
                <div class="top-logo">
                    <a href="{{ route('home') }}" title="{{ $settings['title'] ?? config('app.name') }}"
                        class="transition-all duration-300 hover:scale-105 hover:drop-shadow-[0_0_8px_rgba(40,167,69,0.6)] inline-block">
                        
                        <svg class="h-8 sm:h-10 w-auto" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="45" fill="#FFFFFF" stroke="#22C55E" stroke-width="4" />
                            <circle cx="50" cy="50" r="30" fill="#22C55E" />
                            <rect x="35" y="35" width="30" height="30" rx="5" fill="#FFFFFF" />
                        </svg>
                    </a>
                </div>
            </div>

            
            <div class="w-full sm:w-auto flex flex-wrap items-center justify-center gap-2 sm:gap-3 order-3 sm:order-2">
                @if($settings['email'] ?? null)
                    <div class="top-contact">
                        <a href="mailto:{{ $settings['email'] }}"
                            class="inline-flex items-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1 sm:py-1.5 text-gray-300 text-xs sm:text-sm font-medium rounded-full border border-white/10 bg-white/5 transition-all duration-300 hover:text-white hover:bg-green-500 hover:border-emerald-400 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(40,167,69,0.4)]">
                            <i class="fas fa-envelope text-green-500 text-xs sm:text-sm transition-all duration-300"></i>
                            <span class="hidden xs:inline">{{ $settings['email'] }}</span>
                        </a>
                    </div>
                @endif
                @if($settings['tel'] ?? null)
                    <div class="top-contact">
                        <a href="tel:{{ $settings['tel'] }}"
                            class="inline-flex items-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1 sm:py-1.5 text-gray-300 text-xs sm:text-sm font-medium rounded-full border border-white/10 bg-white/5 transition-all duration-300 hover:text-white hover:bg-green-500 hover:border-emerald-400 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(40,167,69,0.4)]">
                            <i class="fas fa-phone text-green-500 text-xs sm:text-sm transition-all duration-300"
                                aria-hidden="true"></i>
                            <span>{{ $settings['tel'] }}</span>
                        </a>
                    </div>
                @endif
            </div>

            
            <div
                class="w-full sm:w-auto flex items-center justify-center sm:justify-end gap-2 sm:gap-3 order-2 sm:order-3">
                <div class="top-area-language">
                    <div class="lan-text flex gap-2 items-center">
                        <a href="{{ route('home') }}"
                            class="inline-block transition-all duration-300 rounded-md overflow-hidden border-2 border-green-500 shadow-[0_0_12px_rgba(40,167,69,0.6)] opacity-100">
                            
                            <svg class="w-7 h-5 block" viewBox="0 0 28 20" xmlns="http://www.w3.org/2000/svg">
                                <rect width="28" height="6.67" fill="#239F40" />
                                <rect y="6.67" width="28" height="6.67" fill="#FFFFFF" />
                                <rect y="13.33" width="28" height="6.67" fill="#DA0000" />
                                <text x="14" y="12" font-size="8" fill="#DA0000" text-anchor="middle"
                                    font-weight="bold">☪</text>
                            </svg>
                        </a>
                        <a href="{{ route('home') }}?lang=en"
                            class="inline-block transition-all duration-300 rounded-md overflow-hidden border-2 border-white/20 opacity-70 hover:border-green-500 hover:-translate-y-1 hover:scale-110 hover:shadow-[0_4px_12px_rgba(40,167,69,0.5)] hover:opacity-100">
                            
                            <svg class="w-7 h-5 block" viewBox="0 0 28 20" xmlns="http://www.w3.org/2000/svg">
                                <rect width="28" height="20" fill="#012169" />
                                <path d="M0,0 L28,20 M28,0 L0,20" stroke="#FFFFFF" stroke-width="2" />
                                <path d="M0,0 L28,20 M28,0 L0,20" stroke="#C8102E" stroke-width="1.33" />
                                <path d="M14,0 L14,20 M0,10 L28,10" stroke="#FFFFFF" stroke-width="3.33" />
                                <path d="M14,0 L14,20 M0,10 L28,10" stroke="#C8102E" stroke-width="2" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="get-quote">
                    @auth
                        <a class="px-3 sm:px-4 py-1 sm:py-1.5 text-xs sm:text-sm font-semibold rounded-full border-2 border-green-500 bg-gradient-to-r from-green-500 to-emerald-400 text-white transition-all duration-300 shadow-[0_2px_10px_rgba(40,167,69,0.3)] hover:-translate-y-1 hover:scale-105 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)] hover:from-emerald-400 hover:to-green-500 whitespace-nowrap"
                            href="{{ route('user.profile.show') }}">
                            <span class="hidden sm:inline">{{ auth()->user()->getFullName() ?: 'پروفایل' }}</span>
                            <span class="sm:hidden">پروفایل</span>
                        </a>
                    @else
                        <a class="px-3 sm:px-4 py-1 sm:py-1.5 text-xs sm:text-sm font-semibold rounded-full border-2 border-green-500 bg-gradient-to-r from-green-500 to-emerald-400 text-white transition-all duration-300 shadow-[0_2px_10px_rgba(40,167,69,0.3)] hover:-translate-y-1 hover:scale-105 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)] hover:from-emerald-400 hover:to-green-500 whitespace-nowrap"
                            href="{{ route('auth.login') }}">
                            <span class="hidden sm:inline">عضویت / ورود</span>
                            <span class="sm:hidden">ورود</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>