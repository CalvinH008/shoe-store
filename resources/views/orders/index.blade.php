@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <div style="max-width:600px; margin:20px auto;">
        <h2>My Orders</h2>

        @forelse ($orders as $order)
            <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:15px;">
                <div style="display:flex; justify-content:space-between;">
                    <strong>Order #{{ $order->id }}</strong>
                    <span
                        style="
                        padding:4px 10px;
                        border-radius:20px;
                        font-size:12px;
                        background:{{ $order->status === 'completed' ? '#e8f5e9' : ($order->status === 'cancelled' ? '#ffebee' : '#fff3e0') }};
                        color:{{ $order->status === 'completed' ? '#2e7d32' : ($order->status === 'cancelled' ? '#c62828' : '#e65100') }};
                    ">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p style="margin:8px 0; color:#666;">{{ $order->created_at->format('d M Y H:i') }}</p>
                <p>{{ $order->items->count() }} item(s)</p>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    <a href="{{ route('orders.show', $order->id) }}"
                        style="padding:8px 16px; border:1px solid #000; border-radius:6px; text-decoration:none; font-size:14px;">
                        View Detail
                    </a>
                </div>
            </div>
        @empty
            <div style="border:1px solid #ccc; border-radius:8px; padding:40px; text-align:center;">
                <p>You have no orders yet.</p>
                <a href="{{ route('products.index') }}">Start Shopping</a>
            </div>
        @endforelse

        {{ $orders->links() }}
    </div>
@endsection
