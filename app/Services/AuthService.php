<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'user',
            'is_active' => true
        ]);

        Auth::login($user);
        return $user;
    }

    public function login(array $credentials, bool $remember = false): bool
    {
        if (!Auth::attempt($credentials, $remember)) {
            return false;
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            throw new \RuntimeException('Your account is inactive. Please contact the administrator.');
        }

        request()->session()->regenerate();
        return true;
    }

    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    public function redirectAfterLogin(): string
    {
        return Auth::user()->role === 'admin' ? route('admin.products.index') : route('products.index');
    }
}
