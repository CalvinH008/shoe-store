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