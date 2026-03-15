<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Store — Premium Footwear</title>
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

    {{-- NAVBAR --}}
    <nav class="hero-bg text-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-8 py-5 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <span class="text-2xl">👟</span>
                <span class="font-display font-800 text-xl tracking-widest uppercase">Shoe Store</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('products.index') }}"
                    class="text-sm text-slate-300 hover:text-white transition tracking-wide">Collection</a>
                <a href="{{ route('products.index') }}?category=1"
                    class="text-sm text-slate-300 hover:text-white transition tracking-wide">Running</a>
                <a href="{{ route('products.index') }}?category=2"
                    class="text-sm text-slate-300 hover:text-white transition tracking-wide">Basketball</a>
                <a href="{{ route('products.index') }}?category=3"
                    class="text-sm text-slate-300 hover:text-white transition tracking-wide">Sneakers</a>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('orders.index') }}"
                        class="text-sm text-slate-300 hover:text-white transition">Orders</a>
                    <a href="{{ route('products.index') }}"
                        class="bg-white text-[#1e3a5f] text-sm font-bold px-5 py-2 rounded-full hover:bg-slate-100 transition">
                        Shop Now
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-slate-300 hover:text-white transition">Login</a>
                    <a href="{{ route('register') }}"
                        class="bg-white text-[#1e3a5f] text-sm font-bold px-5 py-2 rounded-full hover:bg-slate-100 transition">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero-bg text-white min-h-[90vh] flex items-center relative overflow-hidden">
        {{-- Background decoration --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300/5 rounded-full translate-y-1/2 -translate-x-1/2">
        </div>

        <div class="max-w-7xl mx-auto px-8 py-20 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Left: Text --}}
                <div>
                    <div
                        class="inline-flex items-center gap-2 bg-blue-400/20 border border-blue-400/30 text-blue-300 text-xs font-bold tracking-widest uppercase px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                        New Arrivals 2025
                    </div>
                    <h1 class="font-display font-900 text-7xl leading-none uppercase mb-6">
                        Design<br>
                        <span class="text-transparent" style="-webkit-text-stroke: 2px rgba(255,255,255,0.3)">&
                            High</span><br>
                        <span class="text-blue-300">Quality</span>
                    </h1>
                    <p class="text-slate-400 text-lg mb-8 max-w-md leading-relaxed">
                        Premium footwear engineered for performance and crafted for style. Find your perfect pair today.
                    </p>
                    <div class="flex items-center gap-4 mb-12">
                        <a href="{{ route('products.index') }}"
                            class="bg-white text-[#1e3a5f] font-bold px-8 py-4 rounded-full hover:bg-slate-100 transition shadow-2xl text-sm uppercase tracking-wide">
                            Explore Collection →
                        </a>
                        @guest
                            <a href="{{ route('register') }}"
                                class="text-white/70 hover:text-white text-sm font-medium transition">
                                Sign Up Free
                            </a>
                        @endguest
                    </div>
                    {{-- Stats --}}
                    <div class="flex gap-10 border-t border-white/10 pt-8">
                        <div>
                            <p class="font-display font-900 text-4xl">30+</p>
                            <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">Products</p>
                        </div>
                        <div class="border-l border-white/10 pl-10">
                            <p class="font-display font-900 text-4xl">5+</p>
                            <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">Top Brands</p>
                        </div>
                        <div class="border-l border-white/10 pl-10">
                            <p class="font-display font-900 text-4xl">100%</p>
                            <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">Authentic</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Featured shoe + grid --}}
                <div class="relative">
                    {{-- Main featured shoe --}}
                    @if ($featuredProducts->first()?->primaryImage)
                        <div class="relative z-10">
                            <div
                                class="w-full aspect-square bg-white/5 backdrop-blur rounded-3xl p-8 flex items-center justify-center">
                                <img src="{{ asset('storage/' . $featuredProducts->first()->primaryImage->image_path) }}"
                                    alt="{{ $featuredProducts->first()->name }}"
                                    class="shoe-float w-full h-full object-contain drop-shadow-2xl">
                            </div>
                            {{-- Product label --}}
                            <div
                                class="absolute bottom-6 left-6 right-6 bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-4 flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-sm">{{ $featuredProducts->first()->name }}</p>
                                    <p class="text-blue-300 font-display font-700 text-lg">Rp
                                        {{ number_format($featuredProducts->first()->price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('products.index') }}"
                                    class="bg-white text-[#1e3a5f] text-xs font-bold px-4 py-2 rounded-full hover:bg-slate-100 transition">
                                    View →
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="w-full aspect-square bg-white/5 rounded-3xl flex items-center justify-center">
                            <span class="text-[180px] shoe-float">👟</span>
                        </div>
                    @endif

                    {{-- Small product thumbnails --}}
                    <div class="absolute -right-4 top-0 flex flex-col gap-3">
                        @foreach ($featuredProducts->skip(1)->take(3) as $product)
                            <div
                                class="w-16 h-16 bg-white/10 backdrop-blur rounded-xl overflow-hidden border border-white/20">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                        alt="{{ $product->name }}" class="w-full h-full object-contain p-1">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- POPULAR PRODUCTS --}}
    <section class="py-20 px-8 bg-slate-50">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <p class="text-[#1e3a5f] text-xs font-bold tracking-widest uppercase mb-2">— Featured</p>
                    <h2 class="font-display font-900 text-5xl uppercase">Our Popular<br>Products</h2>
                </div>
                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-2 text-[#1e3a5f] font-semibold text-sm hover:gap-3 transition-all">
                    Explore More →
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    <div class="bg-white rounded-2xl overflow-hidden card-hover shadow-sm hover:shadow-xl group">
                        {{-- Image --}}
                        <div class="bg-slate-100 h-52 flex items-center justify-center p-4 overflow-hidden relative">
                            @if ($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-contain group-hover:scale-110 transition duration-500">
                            @else
                                <span class="text-6xl">👟</span>
                            @endif
                            {{-- Quick add overlay --}}
                            <div
                                class="absolute inset-0 bg-[#1e3a5f]/0 group-hover:bg-[#1e3a5f]/5 transition duration-300">
                            </div>
                        </div>
                        {{-- Info --}}
                        <div class="p-4">
                            <p class="text-xs text-slate-400 uppercase tracking-widest mb-1">Premium</p>
                            <h3 class="font-bold text-sm leading-tight line-clamp-1 mb-2">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <p class="text-[#1e3a5f] font-display font-800 text-lg">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('products.index') }}"
                                class="mt-3 block text-center bg-[#1e3a5f] text-white text-xs font-bold py-2.5 rounded-xl hover:bg-[#162d4a] transition">
                                Add To Cart
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BEST COLLECTION BANNER --}}
    <section class="py-20 px-8 hero-bg text-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-blue-300 text-xs font-bold tracking-widest uppercase mb-3">— Limited Offer</p>
                    <h2 class="font-display font-900 text-5xl uppercase leading-none mb-6">
                        Best Shoes<br>Collection
                    </h2>
                    <p class="text-slate-400 mb-8 max-w-sm">
                        Discover our handpicked selection of premium shoes from the world's top brands.
                    </p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center gap-2 bg-white text-[#1e3a5f] font-bold px-8 py-4 rounded-full hover:bg-slate-100 transition">
                        Shop Collection →
                    </a>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($featuredProducts->take(6) as $product)
                        <div
                            class="bg-white/10 backdrop-blur rounded-2xl p-3 aspect-square flex items-center justify-center overflow-hidden hover:bg-white/20 transition">
                            @if ($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-contain hover:scale-110 transition">
                            @else
                                <span class="text-4xl">👟</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="py-16 px-8 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 bg-[#1e3a5f]/10 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                    🚀</div>
                <div>
                    <h3 class="font-bold mb-1">Fast Delivery</h3>
                    <p class="text-slate-500 text-sm">Get your shoes delivered within 2-3 business days.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 bg-[#1e3a5f]/10 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                    ✅</div>
                <div>
                    <h3 class="font-bold mb-1">100% Authentic</h3>
                    <p class="text-slate-500 text-sm">Every product guaranteed authentic from official distributors.
                    </p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 bg-[#1e3a5f]/10 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                    🔄</div>
                <div>
                    <h3 class="font-bold mb-1">Easy Returns</h3>
                    <p class="text-slate-500 text-sm">Return within 30 days for a full refund, no questions asked.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 text-slate-400 py-8 px-8">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <p class="font-display font-700 text-white text-lg">👟 Shoe Store</p>
            <p class="text-sm">© {{ date('Y') }} Shoe Store. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
