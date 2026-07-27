<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Lempar user ke halaman Login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Tangkap balikan data dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah email sudah ada di database
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Kalau belum ada, otomatis daftarkan akun baru!
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)), // Kasih password acak yang kuat
                    'role' => 'customer', // Default role
                    
                    // --- TAMBAHAN BARUNYA DI SINI ---
                    'email_verified_at' => now(), // Otomatis catat waktu terverifikasi
                    'profile_photo' => $googleUser->getAvatar(), // Ambil URL foto dari akun Google
                ]);
            }

            // Langsung login-kan user tersebut
            Auth::login($user);

            // Cek role, lempar ke tempat yang sesuai
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }

            return redirect()->route('home');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }
}