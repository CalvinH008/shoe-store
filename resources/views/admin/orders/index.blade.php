@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'Manage all customer orders')

@section('content')

    <div x-data="orderManager('{{ route('admin.orders.update-status', ['order' => 0]) }}')" x-init="fetchOrders()">

        {{-- NOTIF --}}
        <div x-show="message" x-transition :class="isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700'"
            class="mb-4 px-4 py-2 rounded-xl text-sm shadow-sm">
            <span x-text="message"></span>
        </div>

        <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">

            {{-- HEADER --}}
            <div class="flex justify-between items-center px-6 py-5 border-b bg-gradient-to-r from-slate-50 to-white">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Orders</h3>
                    <p class="text-xs text-slate-400">Manage customer transactions</p>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="divide-y">

                <template x-for="order in orders" :key="order.id">

                    <div class="hover:bg-slate-50 transition">

                        {{-- MAIN ROW --}}
                        <div class="grid grid-cols-4 items-center px-6 py-4 cursor-pointer"
                            @click="order.open = !order.open">

                            {{-- ORDER ID --}}
                            <div>
                                <p class="font-semibold text-slate-800">
                                    #<span x-text="order.id"></span>
                                </p>
                                <p class="text-xs text-slate-400">Order ID</p>
                            </div>

                            {{-- USER --}}
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#1e3a5f]/10 flex items-center justify-center text-sm font-bold text-[#1e3a5f]">
                                    <span x-text="order.name.charAt(0)"></span>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700" x-text="order.name"></p>
                                    <p class="text-xs text-slate-400" x-text="order.phone"></p>
                                </div>
                            </div>

                            {{-- TOTAL --}}
                            <div>
                                <p class="font-semibold text-slate-800">
                                    Rp <span x-text="order.total_price.toLocaleString('id-ID')"></span>
                                </p>
                                <p class="text-xs text-slate-400">Total</p>
                            </div>

                            {{-- STATUS --}}
                            <div class="flex items-center justify-between">

                                <select x-model="order.status" @click.stop @change="updateStatus(order)"
                                    class="px-3 py-1 text-xs rounded-full border font-medium"
                                    :class="{
                                        'bg-yellow-100 text-yellow-700': order.status === 'pending',
                                        'bg-blue-100 text-blue-700': order.status === 'paid',
                                        'bg-purple-100 text-purple-700': order.status === 'shipped',
                                        'bg-green-100 text-green-700': order.status === 'completed',
                                        'bg-red-100 text-red-600': order.status === 'cancelled',
                                    }">

                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>

                                </select>

                                {{-- ICON --}}
                                <span class="text-slate-400 text-sm">
                                    <span x-text="order.open ? '▲' : '▼'"></span>
                                </span>
                            </div>

                        </div>

                        {{-- EXPAND --}}
                        <div x-show="order.open" x-transition class="bg-slate-50 px-6 pb-6">

                            <div class="grid md:grid-cols-2 gap-6 mt-4">

                                {{-- INFO --}}
                                <div class="bg-white rounded-xl p-4 border">
                                    <h4 class="font-semibold text-slate-700 mb-3">Order Details</h4>

                                    <div class="space-y-2 text-sm text-slate-600">
                                        <p><b>Name:</b> <span x-text="order.name"></span></p>
                                        <p><b>Phone:</b> <span x-text="order.phone"></span></p>
                                        <p><b>Payment:</b> <span x-text="order.payment_method"></span></p>

                                        <p>
                                            <b>Address:</b><br>
                                            <span x-text="order.shipping_address"></span>
                                        </p>

                                        <p x-show="order.notes">
                                            <b>Notes:</b><br>
                                            <span class="italic text-slate-500" x-text="order.notes"></span>
                                        </p>
                                    </div>
                                </div>

                                {{-- PRODUCTS --}}
                                <div class="bg-white rounded-xl p-4 border">
                                    <h4 class="font-semibold text-slate-700 mb-3">Products</h4>

                                    <template x-if="order.items.length === 0">
                                        <p class="text-slate-400 text-sm">No products</p>
                                    </template>

                                    <template x-for="item in order.items" :key="item.id">
                                        <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
                                            <div>
                                                <p class="text-slate-700 font-medium"
                                                    x-text="item.product?.name ?? 'Deleted Product'"></p>
                                                <p class="text-xs text-slate-400">
                                                    Qty: <span x-text="item.quantity"></span>
                                                </p>
                                            </div>
                                            <p class="font-semibold text-slate-800">
                                                Rp <span x-text="item.price.toLocaleString('id-ID')"></span>
                                            </p>
                                        </div>
                                    </template>

                                    <div class="mt-3 pt-3 border-t font-bold text-slate-800 text-sm">
                                        Total:
                                        Rp <span x-text="order.total_price.toLocaleString('id-ID')"></span>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </template>

            </div>

            {{-- PAGINATION --}}
            <div class="flex justify-end items-center gap-3 px-6 py-4 border-t">

                <button @click="changePage(currentPage - 1)"
                    class="px-3 py-1.5 rounded-lg border text-sm hover:bg-slate-100" :disabled="currentPage === 1">
                    Prev
                </button>

                <span class="text-sm text-slate-500" x-text="'Page ' + currentPage + ' / ' + lastPage"></span>

                <button @click="changePage(currentPage + 1)"
                    class="px-3 py-1.5 rounded-lg border text-sm hover:bg-slate-100" :disabled="currentPage === lastPage">
                    Next
                </button>

            </div>

        </div>

    </div>

@endsection
