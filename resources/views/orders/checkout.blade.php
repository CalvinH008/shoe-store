@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div style="max-width:600px; margin:20px auto;">

        {{-- Card: Cart Summary --}}
        <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:20px;">
            <h3>Order Summary</h3>
            <div id="cart-summary">Loading...</div>
            <hr>
            <p><strong>Total: <span id="cart-total">-</span></strong></p>
        </div>

        {{-- Card: Shipping Address --}}
        <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:20px;">
            <h3>Shipping Address</h3>
            <textarea id="shipping_address" rows="4" style="width:100%;" placeholder="Enter your full shipping address..."></textarea>
        </div>

        {{-- Action --}}
        <button id="btn-checkout" onclick="submitCheckout()"
            style="width:100%; padding:12px; background:#000; color:#fff; border:none; border-radius:8px; cursor:pointer;">
            Place Order
        </button>

        <div id="checkout-message" style="margin-top:10px; color:red;"></div>
    </div>
@endsection

@push('scripts')
    <script>
        // Load cart summary saat halaman dibuka
        document.addEventListener('DOMContentLoaded', async function() {
            const cart = await getCart();
            const summary = document.getElementById('cart-summary');
            const total = document.getElementById('cart-total');

            if (!cart || !cart.items || cart.items.length === 0) {
                summary.innerHTML = '<p>Your cart is empty.</p>';
                document.getElementById('btn-checkout').disabled = true;
                return;
            }

            let html = '';
            cart.items.forEach(item => {
                html += `<div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                <span>${item.product.name} x${item.quantity}</span>
                <span>Rp ${(item.product.price * item.quantity).toLocaleString('id-ID')}</span>
            </div>`;
            });
            summary.innerHTML = html;
            let totalAmount = 0;
            cart.items.forEach(item => {
                totalAmount += item.product.price * item.quantity;
            });
            total.textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');
        });

        async function submitCheckout() {
            const address = document.getElementById('shipping_address').value;
            const message = document.getElementById('checkout-message');
            const btn = document.getElementById('btn-checkout');

            btn.disabled = true;
            btn.textContent = 'Processing...';
            message.textContent = '';

            try {
                const response = await axios.post('/checkout', {
                    shipping_address: address
                });

                if (response.data.status) {
                    window.location.href = response.data.data.redirect;
                }
            } catch (error) {
                if (error.response?.status === 422) {
                    const errors = error.response.data.errors;
                    message.textContent = errors ?
                        Object.values(errors).flat().join(', ') :
                        error.response.data.message;
                } else {
                    message.textContent = error.response?.data?.message ?? 'Checkout failed.';
                }
                btn.disabled = false;
                btn.textContent = 'Place Order';
            }
        }
    </script>
@endpush
