<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil (Diarahkan ke desain custom).
     */
    public function edit(Request $request): View
    {
        return view('pages.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update data profil user.
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. Validasi Input dari form
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // Maksimal 2MB
        ]);

        $user = $request->user();

        // 2. Gabungkan Nama Depan dan Belakang untuk disimpan ke kolom 'name'
        $fullName = trim($request->first_name . ' ' . $request->last_name);
        $user->name = $fullName;

        // 3. Simpan Nomor Telepon
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->has('birth_date')) {
            $user->birth_date = $request->birth_date;
        }

        if ($request->hasFile('avatar')) {
            // Jika user sudah punya foto lama, hapus agar penyimpanan tidak penuh
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            
            // Simpan foto baru ke folder 'avatars' di dalam public storage
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        // Kembali ke halaman profil dengan pesan sukses
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}