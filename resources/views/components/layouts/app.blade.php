@props(['title' => null, 'dir' => 'rtl'])

@php
    // Settings are automatically provided by SettingComposer for frontend views
    $settings = $settings ?? [];
    $siteTitle = $settings['title'] ?? config('app.name', 'Laravel');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? $siteTitle }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="antialiased">
    <!-- Top Area -->
    <x-web.top-bar :settings="$settings" />

    <!-- Navigation -->
    <x-web.navigation />

    <!-- Main Content -->
    {{ $slot }}

    <!-- Footer -->
    <x-web.footer />

    <!-- Scroll to Top Button -->
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