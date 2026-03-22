<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function checkout(int $userId, array $data): Order
    {
        return DB::transaction(function () use ($userId, $data) {
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
                'name' => $data['name'] ?? 'No Name',
                'phone' => $data['phone'] ?? '000000000000',
                'payment_method' => $data['payment_method'] ?? 'cod',
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
                'total_price' => $totalPrice,
                'shipping_address' => $data['shipping_address'] ?? null
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

            $cart->items()->delete();
            // tandai cart sebagai completed
            $cart->update(['status' => 'converted']);

            return $order->load('items.product.primaryImage');
        });
    }

    public function getUserOrders(int $userId): LengthAwarePaginator{
        return Order::where('user_id', $userId)
                    ->with('items.product.primaryImage')
                    ->latest()
                    ->paginate(10);
    }

    public function getOrderDetail(int $orderId, int $userId ): Order{
        return Order::where('id', $orderId)
                    ->where('user_id', $userId)
                    ->with('items.product.primaryImage')
                    ->firstOrFail();
    }
}
