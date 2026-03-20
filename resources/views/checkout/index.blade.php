<div id="checkoutModal"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 transition">

    <div class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl overflow-hidden relative animate-[fadeIn_.25s_ease]">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-8 py-5 border-b bg-[#1e3a5f]">
            <div>
                <h2 class="text-xl font-semibold text-white">Checkout</h2>
                <p class="text-sm text-blue-200">Complete your order details</p>
            </div>
            <button onclick="closeCheckoutModal()"
                class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-white/20 text-white transition">
                ✕
            </button>
        </div>

        <form id="checkoutForm" onsubmit="submitCheckout(event)" class="p-8">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                {{-- LEFT (FORM) --}}
                <div class="lg:col-span-3 space-y-5">

                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Customer Info</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Full Name" class="input-style" required>
                        <input type="text" name="phone" placeholder="Phone Number" class="input-style" required>
                    </div>

                    <textarea name="address" placeholder="Full Address" class="input-style h-24" required></textarea>

                    {{-- PAYMENT --}}
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-3">Payment Method</p>
                        <div class="space-y-3">
                            <label class="payment-row text-sm">
                                <input type="radio" name="payment_method" value="bank" class="hidden" required>
                                <div class="flex items-center justify-between w-full">
                                    <div class="flex items-start gap-3">
                                        <div class="icon-box">🏦</div>
                                        <div>
                                            <p class="font-medium text-slate-700">Bank Transfer</p>
                                            <p class="text-xs text-slate-400">BCA, BRI, Mandiri</p>
                                        </div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </div>
                            </label>

                            <label class="payment-row">
                                <input type="radio" name="payment_method" value="ewallet" class="hidden">
                                <div class="flex items-center justify-between w-full">
                                    <div class="flex items-start gap-3">
                                        <div class="icon-box">💳</div>
                                        <div>
                                            <p class="font-medium text-slate-700">E-Wallet</p>
                                            <p class="text-xs text-slate-400">GoPay, OVO, Dana, ShopeePay</p>
                                        </div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </div>
                            </label>

                            <label class="payment-row">
                                <input type="radio" name="payment_method" value="cod" class="hidden">
                                <div class="flex items-center justify-between w-full">
                                    <div class="flex items-start gap-3">
                                        <div class="icon-box">📦</div>
                                        <div>
                                            <p class="font-medium text-slate-700">Cash on Delivery</p>
                                            <p class="text-xs text-slate-400">Pay when received</p>
                                        </div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <p class="text-sm font-medium text-slate-600 mb-3">ANNOTATION</p>
                    <textarea name="notes" placeholder="Extra Details (Max.200 characters)" class="input-style h-24"></textarea>

                </div>

                {{-- RIGHT (SUMMARY) --}}
                <div class="lg:col-span-2">
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 sticky top-4 shadow-sm">
                        <h3 class="font-semibold mb-4 text-slate-800 text-lg">Order Summary</h3>

                        <div class="space-y-3 max-h-56 overflow-y-auto pr-1 text-sm">
                            @foreach ($cart->items as $item)
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-white rounded-lg flex items-center justify-center border">
                                            @if ($item->product->primaryImage)
                                                <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                                                    class="w-full h-full object-contain p-1">
                                            @else
                                                👟
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-slate-700 text-sm font-medium leading-tight">
                                                {{ $item->product->name }}</p>
                                            <p class="text-xs text-slate-400">x{{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t my-4"></div>

                        <div class="flex justify-between items-center text-base font-semibold">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="text-[#1e3a5f] text-lg">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ERROR MESSAGE --}}
            <p id="checkoutMsg" class="text-red-500 text-sm mt-4 text-center"></p>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
                <button type="button" onclick="closeCheckoutModal()"
                    class="px-5 py-3 rounded-xl font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                    Cancel
                </button>
                <button type="submit" id="placeOrderBtn"
                    class="px-6 py-3 rounded-xl font-semibold bg-[#1e3a5f] text-white hover:bg-[#162d4a] transition shadow-lg hover:shadow-xl">
                    Place Order
                </button>
            </div>

        </form>
    </div>
</div>
