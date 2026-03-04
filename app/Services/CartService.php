<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;

class CartService
{
    public function addItem(int $userId, int $productId, int $quantity){
        $cart = Cart::firstOrCreate([
            'user_id' => $userId,
            'status' => 'active'
        ]);

        $cartItem = CartItem::firstOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $productId],
            ['quantity' => 0]
        );

        $cartItem->increment('quantity', $quantity);

        return $cart->load('items');
    }

    public function updateQuantity(int $userId, int $cartItemId, int $quantity){
        if($quantity < 1){
            throw new \InvalidArgumentException('Quantity must be at least 1');
        }

        // ambil cart milik user yang active
        $cart = Cart::where('user_id', $userId)
                    ->where('status', 'active')
                    ->firstOrFail();

        // cari item lewat relasi cart
        $cartItem = $cart->items()->where('id', $cartItemId)->firstOrFail();

        // update quantity
        $cartItem->update([
            'quantity' => $quantity
        ]);
        return $cart->load('items.product');
    }
}
