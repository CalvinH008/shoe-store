@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'Manage all customer orders')

@section('content')

<div x-data="orderManager()" x-init="fetchOrders()">

    {{-- NOTIF --}}
    <div x-show="message"
        :class="isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'"
        class="mb-4 px-4 py-2 rounded-lg text-sm">
        <span x-text="message"></span>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-semibold text-slate-800 text-lg">All Orders</h3>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="text-left text-xs uppercase text-slate-400 border-b">
                        <th class="pb-3">Order</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    <template x-for="order in orders" :key="order.id">
                        <tr class="hover:bg-slate-50 transition">

                            <td class="py-4 font-semibold text-slate-700">
                                #<span x-text="order.id"></span>
                            </td>

                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-[#1e3a5f]/10 flex items-center justify-center text-sm font-bold text-[#1e3a5f]">
                                        <span x-text="order.user.name.charAt(0)"></span>
                                    </div>
                                    <div>
                                        <p class="text-slate-700 font-medium" x-text="order.user.name"></p>
                                        <p class="text-xs text-slate-400" x-text="order.user.email"></p>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 font-medium text-slate-800">
                                Rp <span x-text="order.total.toLocaleString('id-ID')"></span>
                            </td>

                            <td class="py-4">
                                <span
                                    class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                    <span x-text="order.status"></span>
                                </span>
                            </td>

                        </tr>
                    </template>

                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="flex justify-end mt-6 gap-2">
            <button @click="changePage(currentPage - 1)"
                class="px-3 py-1 border rounded-lg"
                :disabled="currentPage === 1">
                Prev
            </button>

            <span class="px-3 py-1 text-sm text-slate-600"
                x-text="'Page ' + currentPage + ' / ' + lastPage">
            </span>

            <button @click="changePage(currentPage + 1)"
                class="px-3 py-1 border rounded-lg"
                :disabled="currentPage === lastPage">
                Next
            </button>
        </div>

    </div>

</div>

@endsection