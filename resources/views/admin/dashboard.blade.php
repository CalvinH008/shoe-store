@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your store performance')

@section('content')

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl">💰</span>
                <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-1 rounded-full">Revenue</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            <p class="text-sm text-slate-400 mt-1">Total Revenue</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl">📦</span>
                <span class="text-xs font-semibold text-blue-500 bg-blue-50 px-2 py-1 rounded-full">Orders</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_orders']) }}</p>
            <p class="text-sm text-slate-400 mt-1">Total Orders</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl">👟</span>
                <span class="text-xs font-semibold text-purple-500 bg-purple-50 px-2 py-1 rounded-full">Products</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_products']) }}</p>
            <p class="text-sm text-slate-400 mt-1">Total Products</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl">👥</span>
                <span class="text-xs font-semibold text-orange-500 bg-orange-50 px-2 py-1 rounded-full">Users</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_users']) }}</p>
            <p class="text-sm text-slate-400 mt-1">Total Users</p>
        </div>

    </div>

    {{-- CHART + BEST SELLER --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- REVENUE CHART --}}
        <div class="xl:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 mb-6">Revenue (Last 7 Days)</h3>
            <canvas id="revenueChart" height="100"></canvas>
        </div>

        {{-- BEST SELLER --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 mb-4">Best Sellers</h3>
            <div class="space-y-4">
                @foreach ($bestSellers as $index => $product)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs font-bold text-slate-500">
                            {{ $index + 1 }}
                        </span>
                        <div class="w-10 h-10 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                            @if ($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-lg">👟</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $product->name }}</p>
                            <p class="text-xs text-slate-400">{{ $product->total_sold }} sold</p>
                        </div>
                    </div>
                @endforeach
            </div>
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
                legend: { display: false }
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