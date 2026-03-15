<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shoe-Store')</title>
</head>

<body>
    <nav x-data="{ open: false }">
        <a href="/">Shoe Store</a>
        <button type="button" @click="open = !open">
            Cart (<span id="cart-count">0</span>)
        </button>
        <!-- CART DROPDOWN -->
        <div x-show="open" @click.outside="open = false" style="border:1px solid #ccc;padding:10px;width:250px">
            <p>Cart Preview</p>

            <div id="cart-preview">
                Items will appear here
            </div>

        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/store/cart.js') }}"></script>
    @stack('scripts')
</body>

</html>
