@props([
    'title' => null,
    'dir' => 'rtl',
    'description' => null,
    'keywords' => null,
    'canonical' => null,
    'ogTitle' => null,
    'ogDescription' => null,
    'ogImage' => null,
    'ogUrl' => null,
    'ogType' => 'website',
    'twitterCard' => 'summary_large_image',
    'twitterTitle' => null,
    'twitterDescription' => null,
    'twitterImage' => null,
    'robots' => 'index, follow'
])

@php
    // Settings are automatically provided by SettingComposer for frontend views
    $settings = $settings ?? [];
    $siteTitle = $settings['title'] ?? config('app.name', 'Laravel');

    // Set fallback values for meta tags
    $metaTitle = $title ?? $siteTitle;
    $metaDescription = $description ?? ($settings['description'] ?? 'کیمیازر');
    $metaKeywords = $keywords ?? ($settings['keywords'] ?? '');
    $metaCanonical = $canonical ?? url()->current();
    $metaOgTitle = $ogTitle ?? $metaTitle;
    $metaOgDescription = $ogDescription ?? $metaDescription;
    $metaOgImage = $ogImage ?? asset('images/header_logo.png');
    $metaOgUrl = $ogUrl ?? $metaCanonical;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if($metaKeywords)
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ $metaCanonical }}">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ $metaOgTitle }}">
    <meta property="og:description" content="{{ $metaOgDescription }}">
    <meta property="og:image" content="{{ $metaOgImage }}">
    <meta property="og:url" content="{{ $metaOgUrl }}">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:site_name" content="{{ $siteTitle }}">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $twitterTitle ?? $metaOgTitle }}">
    <meta name="twitter:description" content="{{ $twitterDescription ?? $metaOgDescription }}">
    <meta name="twitter:image" content="{{ $twitterImage ?? $metaOgImage }}">

    <!-- Language Alternate -->
    <link rel="alternate" hreflang="fa-IR" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}?lang=en">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="antialiased">
    
    <x-web.top-bar :settings="$settings" />

    
    <x-web.navigation />

    
    {{ $slot }}

    
    <x-web.footer />

    
    <div class="fixed bottom-8 left-8 z-[999]">
        <a href="#"
            class="w-12.5 h-12.5 bg-gradient-to-br from-green-500 to-emerald-400 text-white flex items-center justify-center rounded-full no-underline text-lg shadow-[0_4px_15px_rgba(40,167,69,0.4)] border-3 border-white/20 transition-all duration-300 hover:-translate-y-1.25 hover:shadow-[0_6px_20px_rgba(40,167,69,0.6)]">
            <i class="fas fa-arrow-up animate-[bounceUp_2s_ease-in-out_infinite]"></i>
        </a>
    </div>

    @stack('scripts')

    <style>
        @keyframes gradient {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        @keyframes bounceUp {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }
    </style>
</body>

</html>