@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-gray-100 pt-28 pb-10 px-4">
        <div class="w-full max-w-3xl mx-auto space-y-6">

            <!-- Success Card -->
            <div class="bg-white rounded-3xl shadow-xl p-8 text-center border border-green-100">
                <div class="flex justify-center mb-5">
                    <div class="bg-green-100 p-5 rounded-full animate-bounce">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-3xl font-bold text-green-600">Order Success 🎉</h2>
                <p class="text-gray-500 mt-2">Order #{{ $order->id }}</p>
                <p class="text-sm text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-3xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Customer Info</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <p class="text-gray-400">Name</p>
                        <p class="font-medium">{{ $order->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Phone</p>
                        <p class="font-medium">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Payment</p>
                        <p class="font-medium capitalize">{{ $order->payment_method }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-gray-400">Address</p>
                        <p class="font-medium">{{ $order->shipping_address }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-gray-400">Notes</p>
                        <p class="font-medium">{{ $order->notes ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Items Card -->
            <div class="bg-white rounded-3xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Items Ordered</h3>

                <div class="space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition">

                            <!-- Product Image -->
                            <img src="{{ $item->product->primaryImage?->image_path
                                ? asset('storage/' . $item->product->primaryImage->image_path)
                                : 'https://via.placeholder.com/150' }}"
                                class="w-16 h-16 object-cover rounded-xl border shadow-sm">

                            <!-- Product Info -->
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-500">Quantity: {{ $item->quantity }}</p>
                            </div>

                            <!-- Price -->
                            <div class="text-right font-semibold text-gray-900">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="border-t mt-6 pt-4 flex justify-between items-center text-lg font-semibold">
                    <span>Total</span>
                    <span class="text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-3xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Order Status</h3>

                <div class="flex items-center justify-between text-sm">
                    <div class="flex flex-col items-center text-green-600">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 font-bold">✓</div>
                        <span class="mt-2">Pending</span>
                    </div>

                    <div class="flex-1 h-1 bg-gray-200 mx-2"></div>

                    <div class="flex flex-col items-center text-gray-400">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200">2</div>
                        <span class="mt-2">Processed</span>
                    </div>

                    <div class="flex-1 h-1 bg-gray-200 mx-2"></div>

                    <div class="flex flex-col items-center text-gray-400">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200">3</div>
                        <span class="mt-2">Shipped</span>
                    </div>

                    <div class="flex-1 h-1 bg-gray-200 mx-2"></div>

                    <div class="flex flex-col items-center text-gray-400">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200">4</div>
                        <span class="mt-2">Completed</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('orders.index') }}"
                    class="flex-1 bg-green-600 text-white py-3 rounded-xl text-center font-semibold hover:bg-green-700 transition shadow">
                    View My Orders
                </a>

                <a href="{{ route('products.index') }}"
                    class="flex-1 border border-gray-300 py-3 rounded-xl text-center font-semibold hover:bg-gray-100 transition">
                    Continue Shopping
                </a>
            </div>

        </div>
    </div>
@endsection
