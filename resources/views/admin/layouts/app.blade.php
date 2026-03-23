<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Shoe Store</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Barlow', sans-serif;
        }

        .font-display {
            font-family: 'Barlow Condensed', sans-serif;
        }
    </style>
</head>

{{-- 🔥 GLOBAL STORE DISINI --}}

<body class="bg-slate-50 overflow-x-hidden" x-data>

    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <div id="main-content" :class="$store.sidebar.collapsed ? 'ml-16' : 'ml-64'"
        class="min-h-screen transition-all duration-300">

        {{-- TOP BAR --}}
        <header
            class="bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-30">

            {{-- LEFT --}}
            <div class="flex flex-col">
                <h1 class="text-lg font-bold text-slate-800 tracking-tight">
                    @yield('page-title', 'Dashboard')
                </h1>

                <p class="text-xs text-slate-400">
                    @yield('page-subtitle', 'Manage your store efficiently')
                </p>
            </div>

            {{-- RIGHT --}}
            <div class="flex items-center gap-4">

                {{-- DATE --}}
                <div class="hidden md:flex items-center gap-2 text-sm text-slate-500">
                    <span>📅</span>
                    <span>{{ now()->format('d M Y') }}</span>
                </div>

                {{-- DIVIDER --}}
                <div class="w-px h-6 bg-slate-200"></div>

                {{-- USER --}}
                <div class="flex items-center gap-3">

                    {{-- AVATAR --}}
                    <div
                        class="w-9 h-9 rounded-full bg-[#1e3a5f] text-white flex items-center justify-center font-semibold text-sm shadow">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    {{-- NAME --}}
                    <div class="hidden sm:block leading-tight">
                        <p class="text-sm font-semibold text-slate-700">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-slate-400">
                            Admin
                        </p>
                    </div>

                </div>

            </div>
        </header>

        {{-- PAGE --}}
        <main class="p-8">
            @yield('content')
        </main>
    </div>

    @vite(['resources/js/app.js'])
    <script src="/js/store/cart.js"></script>
    <script src="{{ asset('js/admin/product.js') }}"></script>
    <script src="{{ asset('js/admin/orders.js') }}"></script>
    <script src="{{ asset('js/admin/users.js') }}"></script>
    @stack('scripts')

</body>

</html>
