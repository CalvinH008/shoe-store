<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shoe Store — Premium Footwear')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Barlow', sans-serif;
        }

        .font-display {
            font-family: 'Barlow Condensed', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 50%, #162d4a 100%);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-6px);
        }

        .shoe-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(-15deg);
            }

            50% {
                transform: translateY(-12px) rotate(-15deg);
            }
        }
    </style>
</head>

<body class="bg-white overflow-x-hidden">
    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @stack('scripts')
    @yield('scripts')
</body>

</html>
