<section id="hero" class="hero-bg text-white min-h-screen flex items-center relative overflow-hidden">

    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-8 py-20 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- LEFT TEXT --}}
            <div>

                <div
                    class="inline-flex items-center gap-2 bg-blue-400/20 border border-blue-400/30 text-blue-300 text-xs font-bold tracking-widest uppercase px-4 py-2 rounded-full mb-6">
                    <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                    New Arrivals 2026
                </div>

                <h1 class="font-display font-900 text-7xl leading-none uppercase mb-6">
                    Design<br>
                    <span class="text-transparent" style="-webkit-text-stroke:2px rgba(255,255,255,0.3)">
                        & High
                    </span><br>
                    <span class="text-blue-300">Quality</span>
                </h1>

                <p class="text-slate-400 text-lg mb-8 max-w-md leading-relaxed">
                    Premium footwear engineered for performance and crafted for style.
                    Find your perfect pair today.
                </p>

                <div class="flex items-center gap-4 mb-12">
                    <a href="{{ route('products.index') }}"
                        class="bg-white text-[#1e3a5f] font-bold px-8 py-4 rounded-full hover:bg-slate-100 transition shadow-2xl text-sm uppercase tracking-wide">
                        Explore Collection →
                    </a>
                </div>

                <div class="flex gap-10 border-t border-white/10 pt-8">

                    <div>
                        <p class="font-display font-900 text-4xl">30+</p>
                        <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">
                            Products
                        </p>
                    </div>

                    <div class="border-l border-white/10 pl-10">
                        <p class="font-display font-900 text-4xl">5+</p>
                        <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">
                            Top Brands
                        </p>
                    </div>

                    <div class="border-l border-white/10 pl-10">
                        <p class="font-display font-900 text-4xl">100%</p>
                        <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">
                            Authentic
                        </p>
                    </div>

                </div>

            </div>

            {{-- RIGHT IMAGE --}}
            <div class="relative flex items-center justify-center">

                {{-- GLASS BACKGROUND --}}
                <div
                    class="absolute w-[520px] h-[520px] bg-white/10 backdrop-blur-xl border border-white/20 rounded-[40px] rotate-12 shadow-2xl">
                </div>

                @if ($featuredProducts->first()?->primaryImage)
                    {{-- SHOE IMAGE --}}
                    <img src="{{ asset('storage/products/nwujNLV9nIIq0hdCkbvPIdK6diYj8IiRbkfOVsEH.png') }}"
                        class="relative z-10 shoe-float w-[520px] object-contain drop-shadow-2xl rotate-[-12deg]">

                    {{-- PRODUCT CARD --}}
                    <div
                        class="absolute z-20 bottom-6 left-6 right-6 bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-4 flex items-center justify-between">

                        <div>
                            <p class="font-bold text-sm">
                                {{ $featuredProducts->first()->name }}
                            </p>

                            <p class="text-blue-300 font-display font-700 text-lg">
                                Rp {{ number_format($featuredProducts->first()->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <a href="{{ route('products.index') }}"
                            class="bg-white text-[#1e3a5f] text-xs font-bold px-4 py-2 rounded-full hover:bg-slate-100 transition">
                            View →
                        </a>

                    </div>
                @endif

            </div>
        </div>
    </div>

</section>
