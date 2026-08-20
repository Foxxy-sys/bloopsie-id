<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders');

        if ($request->filled('q')) {
            $query->where(function ($sub) use ($request) {
                $sub->where('name', 'like', '%'.$request->q.'%')
                    ->orWhere('email', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,customer',
            'is_member' => 'nullable|boolean',
        ]);

        $data['is_member'] = $request->boolean('is_member');

        // Cegah admin menonaktifkan role admin dirinya sendiri secara tidak sengaja
        if ($user->id === auth()->id() && $data['role'] !== 'admin') {
            return back()->with('error', 'Kamu tidak bisa mengubah role akunmu sendiri.');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        if ($user->orders()->exists()) {
            return back()->with('error', 'Tidak bisa hapus user yang masih punya riwayat order.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}