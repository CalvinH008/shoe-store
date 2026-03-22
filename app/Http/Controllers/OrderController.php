<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    // halaman checkout form input alamat
    public function checkoutPage(): View
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('status', 'active')
            ->with('items.product.primaryImage')
            ->first();

        $total = 0;

        if ($cart && $cart->items) {
            foreach ($cart->items as $item) {
                $total += $item->product->price * $item->quantity;
            }
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->checkout(
                auth()->id(),
                $request->validated()
            );

            $items = $order->items->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'qty' => $item->quantity,
                    'subtotal' => number_format($item->subtotal, 0, ',', '.'),
                    'image' => $item->product->primaryImage?->url ?? null
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Order Placed Successfully',
                'data'    => [
                    'order_id'   => $order->id,
                    'redirect'   => route('orders.success', $order->id),
                    'created_at' => $order->created_at->format('d M Y H:i'),
                    'total'      => number_format($order->total_price, 0, ',', '.'),
                    'address'    => $order->shipping_address,
                    'items'      => $order->items->map(function ($item) {
                        return [
                            'name' => $item->product->name,
                            'qty'  => $item->quantity,
                            'subtotal' => number_format($item->subtotal, 0, ',', '.'),
                        ];
                    }),
                ],
            ]);
        } catch (\InvalidArgumentException $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    // halaman list order user
    public function index(): View
    {
        $orders = $this->orderService->getUserOrders(auth()->id());
        return view('orders.index', compact('orders'));
    }

    // halaman order detail
    public function show(int $id): View
    {
        $order = $this->orderService->getOrderDetail($id, auth()->id());
        return view('orders.show', compact('order'));
    }

    public function success(int $id): View
    {
        $order = $this->orderService->getOrderDetail($id, auth()->id());
        return view('orders.success', compact('order'));
    }

    public function showModal(int $id): View
    {
        $order = $this->orderService->getOrderDetail($id, auth()->id());

        return view('orders.modal', compact('order'));
    }
}
