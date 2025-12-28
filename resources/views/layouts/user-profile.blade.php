<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction ?? 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? __('user/profile.title') }} - {{ config('app.name', 'Laravel') }}</title>

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="flex h-screen bg-gray-100 antialiased">
    <x-user-sidebar />

    <div class="flex-1 flex flex-col overflow-hidden lg:ms-0">
        <x-user-header :title="$headerTitle ?? null" />

        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-auto">
            {{ $slot }}
        </main>
    </div>

    
    <div id="toast-container" class="fixed bottom-4 end-4 z-50 space-y-2"></div>
</body>

</html>