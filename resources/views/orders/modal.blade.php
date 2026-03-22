<div class="w-full flex flex-col">

    {{-- HEADER --}}
    <div class="px-6 py-5 bg-gradient-to-r from-[#1e3a5f] to-[#2c5282] text-white text-center">
        <h2 class="text-lg font-semibold">
            Order #{{ $order->id }}
        </h2>
        <p class="text-xs opacity-80">
            {{ $order->created_at->format('d M Y, H:i') }}
        </p>
    </div>

    {{-- CUSTOMER --}}
    <div class="px-6 py-5 bg-gray-50 border-b text-sm">
        <div class="grid grid-cols-2 gap-y-2">
            <span class="text-gray-400">Name</span>
            <span class="font-medium">{{ $order->name }}</span>

            <span class="text-gray-400">Phone</span>
            <span>{{ $order->phone }}</span>

            <span class="text-gray-400">Payment</span>
            <span class="capitalize">{{ $order->payment_method }}</span>

            <span class="text-gray-400">Address</span>
            <span>{{ $order->shipping_address }}</span>

            @if ($order->notes)
                <span class="text-gray-400">Notes</span>
                <span>{{ $order->notes }}</span>
            @endif
        </div>
    </div>

    {{-- ITEMS --}}
    <div class="px-6 py-5 space-y-4">
        @foreach ($order->items as $item)
            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-lg overflow-hidden border bg-gray-100">
                    @if ($item->product->primaryImage)
                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                            class="w-full h-full object-cover">
                    @endif
                </div>

                <div class="flex-1">
                    <p class="text-sm font-semibold">
                        {{ $item->product->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        Qty: {{ $item->quantity }}
                    </p>
                </div>

                <div class="text-sm font-bold">
                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </div>

            </div>
        @endforeach
    </div>

    {{-- TOTAL --}}
    <div class="px-6 py-5 border-t bg-gray-50 flex justify-between font-semibold">
        <span>Total</span>
        <span class="text-green-600">
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
        </span>
    </div>

</div>
