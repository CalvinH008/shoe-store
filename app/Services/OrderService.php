<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function checkout(int $userId, string $shippingAddress): Order
    {
        return DB::transaction(function () use ($userId, $shippingAddress) {
            // ambil cart user dan itemsnya
            $cart = Cart::where('user_id', $userId)
                ->where('status', 'active')
                ->with('items.product')
                ->first();

            // validasi cart
            if (!$cart || $cart->items->isEmpty()) {
                throw new \InvalidArgumentException('Cart Is Empty');
            }

            // hitung total dan validasi stock
            $totalPrice = 0;
            foreach ($cart->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \InvalidArgumentException("Stock not enough for product: {$item->product->name}.");
                };
                $totalPrice += $item->product->price * $item->quantity;
            }

            // buat order
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'total_price' => $totalPrice,
                'shipping_address' => $shippingAddress
            ]);

            // buat order item dan kurangi stok
            foreach($cart->items as $item){
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);

                // kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }

            // tandai cart sebagai completed
            $cart->update(['status' => 'converted']);

            return $order->load('items.product');
        });
    }

    public function getUserOrders(int $userId): LengthAwarePaginator{
        return Order::where('user_id', $userId)
                    ->with('items.product')
                    ->latest()
                    ->paginate(10);
    }

    public function getOrderDetail(int $orderId, int $userId ): Order{
        return Order::where('id', $orderId)
                    ->where('user_id', $userId)
                    ->with('items.product')
                    ->firstOrFail();
    }
}
