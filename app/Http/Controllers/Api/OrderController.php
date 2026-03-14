<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getUserOrders(auth()->id());
        return response()->json([
            'status' => true,
            'message' => 'Orders Retrieved Successfully',
            'data' => $orders
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->orderService->getOrderDetail($id, auth()->id());
        return response()->json([
            'status' => true,
            'message' => 'Order Retrieved Successfully',
            'data' => $order
        ]);
    }

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->checkout(auth()->id(), $request->validated('shipping_address'));
            return response()->json([
                'status' => true,
                'message' => 'Order Placed Successfully',
                'data' => $order
            ], 201);
        } catch (\InvalidArgumentException $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Checkout Failed',
                'data' => null
            ], 500);
        }
    }
}
