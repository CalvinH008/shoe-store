@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'Manage all customer orders')

@section('content')

    <div x-data="orderManager('{{ route('admin.orders.update-status', ['order' => 0]) }}')" x-init="fetchOrders()">

        {{-- NOTIF --}}
        <div x-show="message" x-transition :class="isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700'"
            class="mb-4 px-4 py-2 rounded-lg text-sm">
            <span x-text="message"></span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            {{-- HEADER --}}
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h3 class="font-semibold text-slate-800 text-lg">All Orders</h3>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs uppercase text-slate-400">
                            <th class="px-6 py-3">Order</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <template x-for="order in orders" :key="order.id">
                        <tbody class="border-b">

                            {{-- MAIN ROW --}}
                            <tr class="hover:bg-slate-50 cursor-pointer transition" @click="order.open = !order.open">

                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    #<span x-text="order.id"></span>
                                </td>

                                <td class="py-4">
                                    <p class="font-medium text-slate-700" x-text="order.name"></p>
                                    <p class="text-xs text-slate-400" x-text="order.phone"></p>
                                </td>

                                <td class="py-4 font-semibold text-slate-800">
                                    Rp <span x-text="order.total_price.toLocaleString('id-ID')"></span>
                                </td>

                                <td class="py-4">
                                    <select x-model="order.status" @click.stop @change="updateStatus(order)"
                                        class="px-3 py-1 text-xs rounded-full border">

                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="shipped">Shipped</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>

                                    </select>
                                </td>
                            </tr>

                            {{-- DETAIL --}}
                            <tr x-show="order.open" x-transition>
                                <td colspan="4" class="bg-slate-50 px-6 py-5">

                                    <div class="grid md:grid-cols-2 gap-6 text-sm">

                                        {{-- LEFT --}}
                                        <div>
                                            <h4 class="font-semibold text-slate-700 mb-2">Order Info</h4>

                                            <p><b>Name:</b> <span x-text="order.name"></span></p>
                                            <p><b>Phone:</b> <span x-text="order.phone"></span></p>
                                            <p><b>Payment:</b> <span x-text="order.payment_method"></span></p>

                                            <p class="mt-2">
                                                <b>Address:</b><br>
                                                <span class="text-slate-600" x-text="order.shipping_address"></span>
                                            </p>

                                            <p class="mt-2" x-show="order.notes">
                                                <b>Notes:</b><br>
                                                <span class="italic text-slate-500" x-text="order.notes"></span>
                                            </p>
                                        </div>

                                        {{-- RIGHT --}}
                                        <div>
                                            <h4 class="font-semibold text-slate-700 mb-2">Products</h4>

                                            <template x-if="order.items.length === 0">
                                                <p class="text-slate-400">No items</p>
                                            </template>

                                            <template x-for="item in order.items" :key="item.id">
                                                <div class="flex justify-between text-slate-600 mb-1">
                                                    <span>
                                                        <span x-text="item.product?.name ?? 'Product deleted'"></span>
                                                        (x<span x-text="item.quantity"></span>)
                                                    </span>
                                                    <span>
                                                        Rp <span x-text="item.price.toLocaleString('id-ID')"></span>
                                                    </span>
                                                </div>
                                            </template>

                                            <div class="border-t mt-2 pt-2 font-semibold text-slate-800">
                                                Total:
                                                Rp <span x-text="order.total_price.toLocaleString('id-ID')"></span>
                                            </div>
                                        </div>

                                    </div>

                                </td>
                            </tr>

                        </tbody>
                    </template>

                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="flex justify-end items-center gap-3 px-6 py-4">

                <button @click="changePage(currentPage - 1)" class="px-3 py-1 border rounded-lg text-sm"
                    :disabled="currentPage === 1">
                    Prev
                </button>

                <span class="text-sm text-slate-500" x-text="'Page ' + currentPage + ' / ' + lastPage">
                </span>

                <button @click="changePage(currentPage + 1)" class="px-3 py-1 border rounded-lg text-sm"
                    :disabled="currentPage === lastPage">
                    Next
                </button>

            </div>

        </div>

    </div>

@endsection
