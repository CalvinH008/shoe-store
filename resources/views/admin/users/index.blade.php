@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')
@section('page-subtitle', 'Manage all users')

@section('content')

    <div x-data="userManager()" x-init="fetchUsers()">

        {{-- NOTIF --}}
        <div x-show="message" x-transition :class="isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700'"
            class="mb-4 px-4 py-2 rounded-xl text-sm shadow-sm">
            <span x-text="message"></span>
        </div>

        <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">

            {{-- HEADER --}}
            <div class="flex justify-between items-center px-6 py-5 border-b bg-gradient-to-r from-slate-50 to-white">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Users</h3>
                    <p class="text-xs text-slate-400">Manage registered users</p>
                </div>
            </div>

            {{-- LIST --}}
            <div class="divide-y">

                <template x-for="user in users" :key="user.id">

                    <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition">

                        {{-- LEFT --}}
                        <div class="flex items-center gap-4">

                            {{-- AVATAR --}}
                            <div
                                class="w-11 h-11 rounded-full bg-[#1e3a5f]/10 flex items-center justify-center font-bold text-[#1e3a5f]">
                                <span x-text="user.name.charAt(0).toUpperCase()"></span>
                            </div>

                            {{-- INFO --}}
                            <div>
                                <p class="font-medium text-slate-800" x-text="user.name"></p>
                                <p class="text-xs text-slate-400" x-text="user.email"></p>
                                <p class="text-xs text-slate-400">
                                    Joined:
                                    <span x-text="new Date(user.created_at).toLocaleDateString()"></span>
                                </p>
                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="flex items-center gap-4">

                            {{-- STATUS --}}
                            <span class="px-3 py-1 text-xs font-medium rounded-full"
                                :class="user.is_active ?
                                    'bg-green-100 text-green-700' :
                                    'bg-red-100 text-red-600'">
                                <span x-text="user.is_active ? 'Active' : 'Disabled'"></span>
                            </span>

                            {{-- ACTION --}}
                            <button @click="toggleUser(user.id)"
                                class="px-3 py-1.5 text-xs font-medium rounded-lg border transition"
                                :class="user.is_active ?
                                    'border-red-200 text-red-500 hover:bg-red-50' :
                                    'border-green-200 text-green-600 hover:bg-green-50'">

                                <span x-text="user.is_active ? 'Disable' : 'Activate'"></span>
                            </button>

                        </div>

                    </div>

                </template>

                {{-- EMPTY --}}
                <template x-if="users.length === 0">
                    <div class="text-center py-10 text-slate-400 text-sm">
                        No users found
                    </div>
                </template>

            </div>

            {{-- PAGINATION --}}
            <div class="flex justify-between items-center px-6 py-4 border-t">

                <p class="text-sm text-slate-400">
                    Page <span x-text="currentPage"></span> of <span x-text="lastPage"></span>
                </p>

                <div class="flex gap-2">

                    <button @click="changePage(currentPage - 1)"
                        class="px-3 py-1.5 rounded-lg border text-sm hover:bg-slate-100 disabled:opacity-50"
                        :disabled="currentPage === 1">
                        Prev
                    </button>

                    <button @click="changePage(currentPage + 1)"
                        class="px-3 py-1.5 rounded-lg border text-sm hover:bg-slate-100 disabled:opacity-50"
                        :disabled="currentPage === lastPage">
                        Next
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
