<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
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
        return view('orders.checkout');
    }

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->checkout(
                auth()->id(),
                $request->validated('shipping_address')
            );

            return response()->json([
                'status' => true,
                'message' => 'Order Placed Successfully',
                'data'    => [
                    'order_id'   => $order->id,
                    'redirect'   => route('orders.success', $order->id),
                ],
            ]);
        } catch (\InvalidArgumentException $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception $error) {
            \Log::error('Checkout error: ' . $error->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Checkout Failed',
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
}
