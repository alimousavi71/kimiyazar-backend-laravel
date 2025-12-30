@php
    // Settings are automatically provided by SettingComposer for frontend views
    $settings = $settings ?? [];
@endphp

<div class="bg-gradient-to-b from-slate-800 to-slate-900 py-2 border-b-4 border-green-500 relative overflow-hidden">
    <div
        class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-green-500 via-emerald-400 to-green-500 bg-[length:200%_100%] animate-[gradient_3s_ease_infinite]">
    </div>
    <div class="container mx-auto px-3 sm:px-4">
        <div class="flex lex-row items-center justify-between gap-2 sm:gap-4">

            <div class="w-full sm:w-auto flex items-center justify-center sm:justify-start order-1 sm:order-1">
                <div class="top-logo">
                    <a href="{{ route('home') }}" title="{{ $settings['title'] ?? config('app.name') }}"
                        class="transition-all duration-300 hover:scale-105 hover:drop-shadow-[0_0_8px_rgba(40,167,69,0.6)] inline-block">

                        <img src="{{ asset('images/header_logo.png') }}"
                            alt="{{ $settings['title'] ?? config('app.name') }}" class="h-8 sm:h-10 w-auto">
                    </a>
                </div>
            </div>


            <div class="w-full sm:w-auto flex flex-wrap items-center justify-center gap-2 sm:gap-3 order-3 sm:order-2">
                @if($settings['top_bar_quote'] ?? null)
                    <div class="hidden md:flex items-center">
                        <p
                            class="text-gray-300 text-xs sm:text-sm font-medium italic text-center px-2 sm:px-3 py-1 rounded-full border border-white/10 bg-white/5">
                            {{ $settings['top_bar_quote'] }}
                        </p>
                    </div>
                @endif
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
                class="w-full sm:w-auto hidden lg:flex  items-center justify-center sm:justify-end gap-2 sm:gap-3 order-2 sm:order-3">
                <div class="top-area-language ">
                    <div class="lan-text flex gap-2 items-center">
                        <a href="{{ route('home') }}"
                            class="inline-block transition-all duration-300 rounded-md overflow-hidden border-2 border-green-500 shadow-[0_0_12px_rgba(40,167,69,0.6)] opacity-100">

                            <svg class="w-7 h-5 block" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="1000" height="572.2"
                                viewBox="-7.217 -4.129 1000 572.2">
                                <path d="M-7.217-4.129h1000v572.2h-1000z" fill="#239f40" />
                                <path d="M-7.217 281.971h1000v286.1h-1000z" fill="#da0000" />
                                <path d="M-7.217 186.571h1000v190.75h-1000z" fill="#fff" />
                                <g transform="translate(-7.217 155.471) scale(4.4445)">
                                    <g id="e">
                                        <g id="c" fill="none" stroke="#fff">
                                            <path id="b"
                                                d="M3 .5h13M3.5 5V2.5h4v2h4v-2H9m-4 2h1m10 0h-2.5v-2h4m0-2.5v4.5h4V0m-2 0v4.5" />
                                            <path id="a" d="M3 7h9m1 0h9" stroke-width="2" />
                                            <use xlink:href="#a" y="42.913" width="100%" height="100%" />
                                            <use xlink:href="#b" y="51.913" width="100%" height="100%" />
                                        </g>
                                        <g id="d">
                                            <use xlink:href="#c" x="20" width="100%" height="100%" />
                                            <use xlink:href="#c" x="40" width="100%" height="100%" />
                                            <use xlink:href="#c" x="60" width="100%" height="100%" />
                                        </g>
                                    </g>
                                    <use xlink:href="#d" x="60" width="100%" height="100%" />
                                    <use xlink:href="#e" x="140" width="100%" height="100%" />
                                </g>
                                <g transform="matrix(69.285 0 0 69.285 492.783 281.971)" fill="#da0000">
                                    <g id="f">
                                        <path d="M-.548.836A.912.912 0 0 0 .329-.722 1 1 0 0 1-.548.836" />
                                        <path
                                            d="M.618.661A.764.764 0 0 0 .422-.74 1 1 0 0 1 .618.661M0 1l-.05-1L0-.787a.31.31 0 0 0 .118.099V-.1l-.04.993zM-.02-.85L0-.831a.144.144 0 0 0 .252-.137A.136.136 0 0 1 0-.925" />
                                    </g>
                                    <use xlink:href="#f" transform="scale(-1 1)" width="100%" height="100%" />
                                </g>
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