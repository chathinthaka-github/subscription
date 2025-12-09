<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request): RedirectResponse
    {
        $key = 'login.'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'username' => ["Too many login attempts. Please try again in {$seconds} seconds."],
            ]);
        }

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'status' => 'active',
        ], $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        RateLimiter::hit($key, 60);

        throw ValidationException::withMessages([
            'username' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

