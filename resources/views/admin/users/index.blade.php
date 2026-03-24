@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')
@section('page-subtitle', 'Manage all users')

@section('content')

    <div x-data="userManager()" x-init="fetchUsers()">

        {{-- NOTIF --}}
        <div x-show="message" x-transition :class="isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700'"
            class="mb-4 px-4 py-2 rounded-lg text-sm">
            <span x-text="message"></span>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

            {{-- HEADER --}}
            <h3 class="font-semibold text-slate-800 text-lg mb-6">All Users</h3>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="text-left text-xs uppercase text-slate-400 border-b">
                            <th class="pb-3">User</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        {{-- DATA --}}
                        <template x-for="user in users" :key="user.id">
                            <tr class="hover:bg-slate-50 transition">

                                {{-- USER --}}
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600">
                                            <span x-text="user.name.charAt(0).toUpperCase()"></span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-700" x-text="user.name"></p>
                                            <p class="text-xs text-slate-400" x-text="user.email"></p>
                                        </div>
                                    </div>
                                </td>

                                {{-- JOINED --}}
                                <td class="py-4 text-slate-400 text-sm"
                                    x-text="new Date(user.created_at).toLocaleDateString()">
                                </td>

                                {{-- STATUS --}}
                                <td class="py-4">
                                    <span class="px-2 py-1 text-xs rounded-full"
                                        :class="user.is_active ?
                                            'bg-green-100 text-green-700' :
                                            'bg-red-100 text-red-600'">
                                        <span x-text="user.is_active ? 'Active' : 'Disabled'"></span>
                                    </span>
                                </td>

                                {{-- ACTION --}}
                                <td class="py-4">
                                    <button @click="toggleUser(user.id)"
                                        class="px-3 py-1.5 text-xs rounded-lg border transition"
                                        :class="user.is_active ?
                                            'border-red-200 text-red-500 hover:bg-red-50' :
                                            'border-green-200 text-green-600 hover:bg-green-50'">

                                        <span x-text="user.is_active ? 'Disable' : 'Activate'"></span>
                                    </button>
                                </td>

                            </tr>
                        </template>

                        {{-- EMPTY --}}
                        <template x-if="users.length === 0">
                            <tr>
                                <td colspan="4" class="text-center py-6 text-slate-400">
                                    No users found
                                </td>
                            </tr>
                        </template>

                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="flex justify-end items-center mt-6 gap-2 text-sm">

                <button @click="changePage(currentPage - 1)"
                    class="px-3 py-1.5 rounded-lg border hover:bg-slate-50 disabled:opacity-50"
                    :disabled="currentPage === 1">
                    ←
                </button>

                <span class="px-3 py-1 text-slate-600">
                    <span x-text="currentPage"></span> /
                    <span x-text="lastPage"></span>
                </span>

                <button @click="changePage(currentPage + 1)"
                    class="px-3 py-1.5 rounded-lg border hover:bg-slate-50 disabled:opacity-50"
                    :disabled="currentPage === lastPage">
                    →
                </button>

            </div>

        </div>

    </div>

@endsection
