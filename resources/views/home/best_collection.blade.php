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