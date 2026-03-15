@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div x-data="{
        cart: null,
        loading: false,
        address: '',
        message: '',
        async init() {
            this.cart = await getCart();
        },
        async checkout() {
            this.loading = true;
            this.message = '';
            try {
                const response = await axios.post('/checkout', { shipping_address: this.address });
                if (response.data.status) {
                    window.location.href = response.data.data.redirect;
                }
            } catch (err) {
                if (err.response?.status === 422) {
                    const errors = err.response.data.errors;
                    this.message = errors ? Object.values(errors).flat().join(', ') : err.response.data.message;
                } else {
                    this.message = err.response?.data?.message ?? 'Checkout failed.';
                }
            } finally {
                this.loading = false;
            }
        }
    }" style="max-width:600px; margin:20px auto;" x-init="init()">

        {{-- Cart Summary --}}
        <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:20px;">
            <h3>Order Summary</h3>
            <template x-if="cart && cart.items && cart.items.length">
                <div>
                    <template x-for="item in cart.items" :key="item.id">
                        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                            <span x-text="`${item.product.name} x${item.quantity}`"></span>
                            <span x-text="`Rp ${ (item.product.price * item.quantity).toLocaleString('id-ID') }`"></span>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="!cart || !cart.items || !cart.items.length">
                <p>Your cart is empty.</p>
            </template>
            <hr>
            <p><strong>Total:
                    <span
                        x-text="cart ? 'Rp ' + cart.items.reduce((sum, i) => sum + i.product.price * i.quantity, 0).toLocaleString('id-ID') : '-'"></span>
                </strong></p>
        </div>

        {{-- Shipping Address --}}
        <div style="border:1px solid #ccc; border-radius:8px; padding:20px; margin-bottom:20px;">
            <h3>Shipping Address</h3>
            <textarea x-model="address" rows="4" style="width:100%;" placeholder="Enter your full shipping address..."></textarea>
        </div>

        {{-- Checkout Button --}}
        <button :disabled="loading || !cart || !cart.items.length || !address" @click="checkout()"
            style="width:100%; padding:12px; background:#000; color:#fff; border:none; border-radius:8px; cursor:pointer;">
            <span x-show="!loading">Place Order</span>
            <span x-show="loading">Processing...</span>
        </button>

        {{-- Message --}}
        <div x-text="message" style="margin-top:10px; color:red;"></div>

    </div>
@endsection

@push('scripts')
@endpush
