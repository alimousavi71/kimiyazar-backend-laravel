@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction ?? 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Authentication' }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased min-h-screen relative overflow-hidden">
    <!-- Animated Background -->
    <div class="fixed inset-0 bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
        <!-- Animated Gradient Orbs -->
        <div
            class="absolute top-0 -start-4 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob">
        </div>
        <div
            class="absolute top-0 -end-4 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 start-20 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000">
        </div>

        <!-- Grid Pattern Overlay -->
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]">
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-20 start-10 w-2 h-2 bg-green-400 rounded-full opacity-40 animate-pulse"></div>
        <div
            class="absolute top-40 end-20 w-3 h-3 bg-emerald-400 rounded-full opacity-40 animate-pulse animation-delay-1000">
        </div>
        <div
            class="absolute bottom-20 start-1/4 w-2 h-2 bg-green-400 rounded-full opacity-40 animate-pulse animation-delay-2000">
        </div>
        <div
            class="absolute bottom-40 end-1/3 w-3 h-3 bg-emerald-400 rounded-full opacity-40 animate-pulse animation-delay-3000">
        </div>
    </div>

    <!-- Content -->
    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 z-10">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-3000 {
            animation-delay: 3s;
        }
    </style>
</body>

</html>