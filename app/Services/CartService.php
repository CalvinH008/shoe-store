<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function addItem(int $userId, int $productId, int $quantity): Cart
    {
        return DB::transaction(function () use ($userId, $productId, $quantity) {
            $product = Product::findOrFail($productId);

            if ($product->stock < $quantity) {
                throw new \InvalidArgumentException(
                    "Stock Not Enough. Stock Avaiable: {$product->stock}"
                );
            }
            $cart = Cart::firstOrCreate([
                'user_id' => $userId,
                'status' => 'active'
            ]);

            $cartItem = CartItem::firstOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $productId],
                ['quantity' => 0]
            );

            $newQuantity = $cartItem->quantity + $quantity;

            if ($newQuantity > $product->stock) {
                throw new \InvalidArgumentException(
                    "Total quantity exceeds stock. Available stock: {$product->stock}"
                );
            }

            $cartItem->increment('quantity', $quantity);

            return $cart->load('items.product');
        });
    }

    public function updateQuantity(int $userId, int $cartItemId, int $quantity)
    {
        // harus diluar transaction
        if ($quantity < 1) {
            throw new \InvalidArgumentException('Quantity must be at least 1');
        }

        DB::transaction(function () use ($userId, $cartItemId, $quantity) {
            // ambil cart milik user yang active
            $cart = Cart::where('user_id', $userId)
                ->where('status', 'active')
                ->firstOrFail();

            // cari item lewat relasi cart
            $cartItem = $cart->items()
                ->where('id', $cartItemId)
                ->firstOrFail();

            if ($quantity > $cartItem->product->stock) {
                throw new \InvalidArgumentException(
                    'Quantity exceeds stock. Stock available: {$cartItem->product->stock}'
                );
            }
            // update quantity
            $cartItem->update([
                'quantity' => $quantity
            ]);

            // eager load
            return $cart->load('items.product');
        });
    }

    public function removeItem(int $userId, int $cartItemId)
    {

        return DB::transaction(function () use ($userId, $cartItemId) {
            // ambil cart milik user yang active
            $cart = Cart::where('user_id', $userId)
                ->where('status', 'active')
                ->firstOrFail();

            // cari item lewat relasi cart
            $cartItem = $cart->items()->where('id', $cartItemId)->firstOrFail();

            // delete item
            $cartItem->delete();

            // eager load
            return $cart->load('items.product');
        });
    }

    public function getCart(int $userId)
    {
        // ambil cart user yang active
        $cart = Cart::firstOrCreate([
            'user_id' => $userId,
            'status' => 'active'
        ]);

        return $cart->load('items.product');
    }
}
