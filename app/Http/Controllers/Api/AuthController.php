<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users.email'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user',
            'is_active' => true
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Register Successfull',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials',
                'data' => null
            ]);
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return response()->json([
                'status' => false,
                'message' => 'Your Account Is Inactive',
                'data' => null
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'true',
            'message' => 'Login Successfull',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged Out',
            'data' => null
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'User Retrieved',
            'data' => $request->user()
        ]);
    }
}
