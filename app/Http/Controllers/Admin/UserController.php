<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function getData(): JsonResponse
    {
        $users = User::latest()->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $users
        ]);
    }

    public function toggleActive(User $user): JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot disable your own account'
            ], 400);
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        return response()->json([
            'status' => true,
            'message' => $user->is_active ? 'User activated' : 'User disabled',
            'data' => $user
        ]);
    }
}
