@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
    <div style="max-width:600px; margin:20px auto;">

        {{-- Card: Success Header --}}
        <div style="border:1px solid #4caf50; border-radius:8px; padding:20px; margin-bottom:20px; text-align:center;">
            <h2 style="color:#4caf50;">✓ Order Placed Successfully!</h2>
            <p>Order #{{ $order->id }}</p>
            <p>{{ $order->created_at->format('d M Y H:i') }}</p>
        </div>

        {{-- Card: Items --}}
        <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:20px;">
            <h3>Items Ordered</h3>
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

        {{-- Actions --}}
        <div style="display:flex; gap:10px;">
            <a href="{{ route('orders.index') }}"
                style="flex:1; padding:12px; background:#000; color:#fff; border-radius:8px; text-align:center; text-decoration:none;">
                View My Orders
            </a>
            <a href="{{ route('products.index') }}"
                style="flex:1; padding:12px; border:1px solid #000; border-radius:8px; text-align:center; text-decoration:none;">
                Continue Shopping
            </a>
        </div>
    </div>
@endsection
