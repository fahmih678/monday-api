<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login()
    {
        if (Auth::check()) {
            // Kalau sudah login, redirect ke dashboard
            if (auth()->user()->hasRole('manager')) {
                return redirect()->route('overview-manager');
            } elseif (auth()->user()->hasRole('keeper')) {
                return redirect()->route('overview-keeper');
            } else {
                abort(403);
            }
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        // Cek kredensial
        if (Auth::attempt($validateData)) {
            // Regenerasi session ID
            $request->session()->regenerate();

            // Redirect ke dashboard / home
            if (auth()->user()->hasRole('manager')) {
                return redirect()->intended('overview');
            } elseif (auth()->user()->hasRole('keeper')) {
                return redirect()->intended('overview-keeper');
            } else {
                abort(403);
            }
        }

        // Kalau gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email'); // isi email tetap ada
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
