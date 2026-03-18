@extends('layouts.app')
@section('title', 'My Cart')
@section('content')

    <div class="max-w-7xl mx-auto px-6 pt-24 pb-10 min-h-[70vh]">
        <h1 class="text-2xl font-bold mb-6">My Cart</h1>

        @if (!$cart || $cart->items->isEmpty())
            <div class="flex items-center justify-center h-full">
                <div class="bg-white rounded-2xl px-16 py-14 text-center shadow-sm w-full max-w-3xl border border-slate-100">

                    <div class="text-6xl mb-6">🛒</div>

                    <h2 class="text-2xl font-bold text-slate-800 mb-3">
                        Your cart is empty
                    </h2>

                    <p class="text-slate-500 mb-8">
                        Looks like you haven't added anything yet.
                    </p>

                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-[#1e3a5f] text-white font-semibold px-8 py-3 rounded-full hover:bg-[#162d4a] transition">
                        Start Shopping
                    </a>

                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($cart->items as $item)
                        <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4"
                            id="cart-item-{{ $item->id }}">
                            {{-- Image --}}
                            <div
                                class="w-24 h-24 bg-slate-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if ($item->product->primaryImage)
                                    <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                                        alt="{{ $item->product->name }}" class="w-full h-full object-contain p-2">
                                @else
                                    <span class="text-3xl">👟</span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1">
                                <h3 class="font-bold text-sm">{{ $item->product->name }}</h3>
                                <p class="text-[#1e3a5f] font-bold mt-1">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Stock: {{ $item->product->stock }}
                                </p>
                            </div>

                            {{-- Quantity Controls --}}
                            <div class="flex items-center gap-2">
                                <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                    class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-600 hover:bg-slate-200 transition">
                                    −
                                </button>
                                <span class="w-8 text-center font-bold text-sm" id="qty-{{ $item->id }}">
                                    {{ $item->quantity }}
                                </span>
                                <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                    class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-600 hover:bg-slate-200 transition">
                                    +
                                </button>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-right min-w-[100px]">
                                <p class="font-bold text-[#1e3a5f]">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Remove --}}
                            <button onclick="removeItem({{ $item->id }})"
                                class="text-slate-300 hover:text-red-500 transition text-lg ml-2">
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-6 shadow-sm sticky top-24">
                        <h2 class="font-bold text-lg mb-4">Order Summary</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-slate-500">
                                <span>Items ({{ $cart->total_items }})</span>
                                <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-slate-500">
                                <span>Shipping</span>
                                <span class="text-green-500 font-semibold">Free</span>
                            </div>
                            <div class="border-t border-slate-100 pt-3 flex justify-between font-bold text-base">
                                <span>Total</span>
                                <span class="text-[#1e3a5f]">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <button onclick="openCheckoutModal()"
                            class="mt-6 w-full bg-[#1e3a5f] text-white font-bold py-3 rounded-xl hover:bg-[#162d4a] transition">
                            Checkout →
                        </button>
                        <a href="{{ route('products.index') }}"
                            class="mt-3 block text-center text-slate-400 text-sm hover:text-slate-600 transition">
                            ← Continue Shopping
                        </a>
                    </div>
                </div>

            </div>
        @endif
    </div>
    @include('checkout.index')
@endsection
@push('scripts')
    <script>
        async function updateQuantity(cartItemId, quantity) {
            if (quantity < 1) {
                return removeItem(cartItemId);
            }
            try {
                const response = await axios.patch(`/cart/items/${cartItemId}`, {
                    quantity
                });
                if (response.data.status) {
                    window.location.reload();
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to update quantity');
            }
        }

        async function removeItem(cartItemId) {
            try {
                const response = await axios.delete(`/cart/items/${cartItemId}`);
                if (response.data.status) {
                    window.location.reload();
                }
            } catch (error) {
                alert('Failed to remove item');
            }
        }

        function openCheckoutModal() {
            document.getElementById('checkoutModal').classList.remove('hidden');
            document.getElementById('checkoutModal').classList.add('flex');
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').classList.add('hidden');
            document.getElementById('checkoutModal').classList.remove('flex');
        }
    </script>
@endpush
