<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        try {
            $this->authService->register($request->validated());
            return redirect($this->authService->redirectAfterLogin());
        } catch (\Exception $error) {
            return back()->withErrors(['error' => 'Registration Failed. Try Again.']);
        }
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $credentials = $request->only(['email', 'password']);
            $remember = $request->boolean('remember');

            $success = $this->authService->login($credentials, $remember);

            if (!$success) {
                return back()->withErrors([
                    'email' => 'The Email Or Password Is Incorrect.'
                ])->onlyInput('email');
            }

            return redirect($this->authService->redirectAfterLogin());
        } catch (\RuntimeException $error) {
            return back()->withErrors(['email' => $error->getMessage()])->onlyInput('email');
        } catch (\Exception $error) {
            return back()->withErrors(['error' => 'Login Failed. Try Again']);
        }
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logout();
        return redirect()->route('login');
    }
}
