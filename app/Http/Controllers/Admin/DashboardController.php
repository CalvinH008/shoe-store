<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_price'),
            'total_orders'  => Order::count(),
            'total_products' => Product::count(),
            'total_users'   => User::where('role', 'user')->count(),
        ];

        $bestSellers = Product::with('primaryImage')
            ->withSum('orderItems', 'quantity')
            ->orderByDesc('order_items_sum_quantity')
            ->take(5)
            ->get()
            ->map(function ($product) {
                $product->total_sold = $product->order_items_sum_quantity ?? 0;
                return $product;
            });

        $chartData = $this->getRevenueChart();

        return view('admin.dashboard', compact('stats', 'bestSellers', 'chartData'));
    }

    private function getRevenueChart(): array
    {
        $labels = [];
        $values = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');
            $values[] = Order::whereDate('created_at', $date)
                ->where('status', '!=', 'cancelled')
                ->sum('total_price');
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
