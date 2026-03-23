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
    
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
