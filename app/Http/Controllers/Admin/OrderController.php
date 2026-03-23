<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function getData(): JsonResponse
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $orders
        ]);
    }
    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Order status updated successfully',
            'order' => $order
        ]);
    }
}
