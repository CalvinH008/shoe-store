<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $this->authService->register($request->validated());
            return redirect($this->authService->redirectAfterLogin());
        } catch (\Exception $error) {
            return back()->withErrors(['error', 'Registration Failed. Try Again.']);
        }
    }

    public function login(LoginRequest $request)
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
    
    public function logout(){
        $this->authService->logout();
        return redirect()->route('login');
    }
}
