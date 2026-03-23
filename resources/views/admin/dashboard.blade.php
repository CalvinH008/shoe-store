@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your store performance')

@section('content')

    {{-- ================= STATS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl">💰</span>
                <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-1 rounded-full">Revenue</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">
                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
            </p>
            <p class="text-sm text-slate-400 mt-1">Total Revenue</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl">📦</span>
                <span class="text-xs font-semibold text-blue-500 bg-blue-50 px-2 py-1 rounded-full">Orders</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">
                {{ number_format($stats['total_orders']) }}
            </p>
            <p class="text-sm text-slate-400 mt-1">Total Orders</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl">👟</span>
                <span class="text-xs font-semibold text-purple-500 bg-purple-50 px-2 py-1 rounded-full">Products</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">
                {{ number_format($stats['total_products']) }}
            </p>
            <p class="text-sm text-slate-400 mt-1">Total Products</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl">👥</span>
                <span class="text-xs font-semibold text-orange-500 bg-orange-50 px-2 py-1 rounded-full">Users</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">
                {{ number_format($stats['total_users']) }}
            </p>
            <p class="text-sm text-slate-400 mt-1">Total Users</p>
        </div>

    </div>

    {{-- ================= CHART + BEST SELLER ================= --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-10">

        {{-- CHART --}}
        <div class="xl:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-6">Revenue (Last 7 Days)</h3>
            <canvas id="revenueChart" height="100"></canvas>
        </div>

        {{-- BEST SELLER --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-4">Best Sellers</h3>

            <div class="space-y-4">
                @foreach ($bestSellers as $index => $product)
                    <div class="flex items-center gap-3">

                        <span
                            class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs font-bold text-slate-500">
                            {{ $index + 1 }}
                        </span>

                        <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                            @if ($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-lg">👟</div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">
                                {{ $product->name }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $product->total_sold }} sold
                            </p>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>

    </div>

    {{-- ================= QUICK ACTION ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

        <a href="{{ route('admin.products.create') }}"
            class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition group">
            <h3 class="font-semibold text-slate-800 mb-1 group-hover:text-[#1e3a5f] transition">
                ➕ Add Product
            </h3>
            <p class="text-sm text-slate-400">Create new product</p>
        </a>

        <a href="{{ route('admin.orders.index') }}"
            class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition group">
            <h3 class="font-semibold text-slate-800 mb-1 group-hover:text-[#1e3a5f] transition">
                📦 View Orders
            </h3>
            <p class="text-sm text-slate-400">Check incoming orders</p>
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition group">
            <h3 class="font-semibold text-slate-800 mb-1 group-hover:text-[#1e3a5f] transition">
                👥 Manage Users
            </h3>
            <p class="text-sm text-slate-400">Control user accounts</p>
        </a>

    </div>

    {{-- ================= RECENT ORDERS ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-semibold text-slate-800 text-lg">Recent Orders</h3>
                <p class="text-xs text-slate-400">Latest transactions from your store</p>
            </div>

            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-[#1e3a5f] hover:underline">
                View All →
            </a>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                {{-- HEAD --}}
                <thead>
                    <tr class="text-left text-xs uppercase text-slate-400 border-b">
                        <th class="pb-3">Order</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y">

                    @for ($i = 1; $i <= 5; $i++)
                        <tr class="hover:bg-slate-50 transition">

                            {{-- ORDER ID --}}
                            <td class="py-4 font-semibold text-slate-700">
                                #00{{ $i }}
                            </td>

                            {{-- USER --}}
                            <td class="py-4">
                                <div class="flex items-center gap-3">

                                    {{-- AVATAR --}}
                                    <div
                                        class="w-9 h-9 rounded-full bg-[#1e3a5f]/10 flex items-center justify-center text-sm font-bold text-[#1e3a5f]">
                                        U{{ $i }}
                                    </div>

                                    {{-- NAME --}}
                                    <div>
                                        <p class="text-slate-700 font-medium">User {{ $i }}</p>
                                        <p class="text-xs text-slate-400">user{{ $i }}@mail.com</p>
                                    </div>

                                </div>
                            </td>

                            {{-- TOTAL --}}
                            <td class="py-4 font-medium text-slate-800">
                                Rp 250.000
                            </td>

                            {{-- STATUS --}}
                            <td class="py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                    ✔ Completed
                                </span>
                            </td>

                        </tr>
                    @endfor

                </tbody>

            </table>
        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($chartData['values']) !!},
                    borderColor: '#1e3a5f',
                    backgroundColor: 'rgba(30, 58, 95, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#1e3a5f',
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
@endpush
