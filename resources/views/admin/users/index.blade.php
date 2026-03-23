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
                            <th class="pb-3">Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        <template x-for="user in users" :key="user.id">
                            <tr class="hover:bg-slate-50 transition">

                                <td class="py-4 font-medium text-slate-700" x-text="user.name"></td>
                                <td class="py-4 text-slate-500" x-text="user.email"></td>
                                <td class="py-4 text-slate-400" x-text="new Date(user.created_at).toLocaleDateString()">
                                </td>
                                <td class="py-4">
                                    <button @click="deleteUser(user)"
                                        class="text-red-600 px-2 py-1 border border-red-300 rounded-lg hover:bg-red-50">
                                        Delete
                                    </button>
                                </td>

                            </tr>
                        </template>

                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="flex justify-end mt-6 gap-2">
                <button @click="changePage(currentPage - 1)" class="px-3 py-1 border rounded-lg"
                    :disabled="currentPage === 1">
                    Prev
                </button>

                <span class="px-3 py-1 text-sm text-slate-600" x-text="'Page ' + currentPage + ' / ' + lastPage">
                </span>

                <button @click="changePage(currentPage + 1)" class="px-3 py-1 border rounded-lg"
                    :disabled="currentPage === lastPage">
                    Next
                </button>
            </div>

        </div>

    </div>

@endsection
