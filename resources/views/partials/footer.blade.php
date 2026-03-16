<footer class="bg-[#1e3a5f] text-white mt-16">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Brand --}}
            <div>
                <h3 class="text-xl font-bold mb-3">👟 Shoe Store</h3>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Your go-to destination for premium footwear. Quality shoes for every occasion.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Products</a></li>
                    @auth
                        <li><a href="{{ route('cart.page') }}" class="hover:text-white transition">My Cart</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-white transition">My Orders</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Info --}}
            <div>
                <h4 class="font-semibold mb-3">Customer Service</h4>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>📧 support@shoestore.com</li>
                    <li>📞 +62 812 3456 7890</li>
                    <li>🕐 Mon–Fri, 09.00–17.00</li>
                </ul>
            </div>

        </div>

        <div class="border-t border-slate-600 mt-8 pt-6 text-center text-sm text-slate-400">
            © {{ date('Y') }} Shoe Store. All rights reserved.
        </div>
    </div>
</footer>