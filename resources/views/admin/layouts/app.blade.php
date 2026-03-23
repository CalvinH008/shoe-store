<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Shoe Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Barlow', sans-serif; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 overflow-x-hidden" x-data>

    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <div id="main-content"
        x-bind:class="$store.sidebar?.collapsed ? 'ml-16' : 'ml-64'"
        class="min-h-screen transition-all duration-300 ml-64">

        {{-- TOP BAR --}}
        <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between sticky top-0 z-30">
            <div>
                <h1 class="text-lg font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-slate-400">@yield('page-subtitle', 'Welcome back, ' . auth()->user()->name)</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500">{{ now()->format('d M Y') }}</span>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="p-8">
            @yield('content')
        </main>
    </div>

    @vite(['resources/js/app.js'])
    <script src="/js/store/cart.js"></script>
    <script src="{{ asset('js/admin/product.js') }}"></script>
    @stack('scripts')
</body>
</html>