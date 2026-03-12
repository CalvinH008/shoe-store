@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
    <div style="max-width:600px; margin:20px auto;">

        {{-- Card: Order Info --}}
        <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:20px;">
            <div style="display:flex; justify-content:space-between;">
                <h3>Order #{{ $order->id }}</h3>
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
            <p style="color:#666;">{{ $order->created_at->format('d M Y H:i') }}</p>
        </div>

        {{-- Card: Items --}}
        <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:20px;">
            <h3>Items</h3>
            @foreach ($order->items as $item)
                <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                    <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
            <hr>
            <div style="display:flex; justify-content:space-between;">
                <strong>Total</strong>
                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
            </div>
        </div>

        {{-- Card: Shipping --}}
        <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:20px;">
            <h3>Shipping Address</h3>
            <p>{{ $order->shipping_address }}</p>
        </div>

        <a href="{{ route('orders.index') }}"
            style="display:block; padding:12px; border:1px solid #000; border-radius:8px; text-align:center; text-decoration:none;">
            Back to My Orders
        </a>
    </div>
@endsection
