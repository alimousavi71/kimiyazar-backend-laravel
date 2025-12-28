@props(['title' => null, 'headerTitle' => null, 'breadcrumbs' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction ?? 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? ($settings['title'] ?? config('app.name', 'Laravel')) }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <script>
        window.adminPrefix = @js(config('admin.prefix'));
    </script>

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="flex h-screen bg-gray-50 antialiased">
    <x-sidebar />

    <div class="flex-1 flex flex-col overflow-hidden lg:ms-0">
        <x-header :title="$headerTitle ?? null" />

        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-2 sm:py-3 lg:py-4 overflow-auto">
            <div class="max-w-7xl mx-auto">
                @if(isset($breadcrumbs) && $breadcrumbs)
                    <div class="flex justify-end mb-2">
                        <x-breadcrumb :items="$breadcrumbs" />
                    </div>
                @endif
                <div class="space-y-4">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    
    <div id="toast-container" class="fixed bottom-4 end-4 z-50 space-y-2"></div>

    @stack('scripts')
</body>

</html>