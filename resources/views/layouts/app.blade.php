<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shoe-Store')</title>
</head>

<body>
    <nav>
        <a href="/">Shoe Store</a>
        <span id="cart-count">0</span> Item
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/store/cart.js') }}"></script>
    @stack('scripts')
</body>

</html>
