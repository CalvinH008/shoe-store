@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <h2 class="text-2xl font-bold text-slate-900 mb-8">My Orders</h2>

        @forelse ($orders as $order)
            <div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-slate-200 transition hover:shadow-lg">
                <div class="flex justify-between items-center mb-2">
                    <strong class="text-lg text-slate-900">Order #{{ $order->id }}</strong>
                    {{-- Status Badge --}}
                    @php
                        $statusColors = [
                            'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                            'pending' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                            'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                        ];
                        $badge = $statusColors[$order->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $badge['bg'] }} {{ $badge['text'] }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <p class="text-sm text-slate-500 mb-2">{{ $order->created_at->format('d M Y H:i') }}</p>
                <p class="text-sm text-slate-700 mb-4">{{ $order->items->count() }} item(s)</p>

                <div class="flex justify-between items-center">
                    <strong class="text-lg text-slate-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    <a href="{{ route('orders.show', $order->id) }}"
                        class="px-4 py-2 bg-[#1e3a5f] text-white rounded-lg text-sm font-semibold hover:bg-[#162d4a] transition">
                        View Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white shadow-md rounded-xl p-10 text-center border border-slate-200">
                <p class="text-slate-500 mb-4">You have no orders yet.</p>
                <a href="{{ route('products.index') }}"
                    class="px-5 py-2 bg-[#1e3a5f] text-white rounded-lg font-semibold hover:bg-[#162d4a] transition">
                    Start Shopping
                </a>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($orders->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $orders->links('vendor.pagination.custom') }}
            </div>
        @endif

    </div>
@endsection
