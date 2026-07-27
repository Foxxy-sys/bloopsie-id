<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Proses Autentikasi Bawaan Breeze
        $request->authenticate();
        $request->session()->regenerate();

        // 2. CEK ROLE USER YANG BARU SAJA LOGIN
        $user = $request->user();

        if ($user->role === 'admin') {
            // Jika admin, lempar ke dashboard admin
            return redirect()->route('dashboard'); 
            // Nanti 'dashboard' ini bisa kamu ganti dengan route admin panel-mu
        }

        // 3. Jika customer biasa, lempar ke halaman Home atau sebelumnya
        return redirect()->intended(route('home'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
