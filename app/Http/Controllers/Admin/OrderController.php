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
}
