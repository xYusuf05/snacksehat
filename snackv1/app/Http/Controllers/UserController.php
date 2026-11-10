<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = User::withCount(['snacks', 'histories']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        if ($status = $request->get('status')) {
            $query->where('is_active', $status === 'aktif');
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total'      => User::count(),
            'admin'      => User::where('role', 'admin')->count(),
            'user'       => User::where('role', 'user')->count(),
            'nonaktif'   => User::where('is_active', false)->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    // ── Show ───────────────────────────────────────────────────────────────────
    public function show(User $user)
    {
        $user->loadCount(['snacks', 'histories']);

        $snacks = $user->snacks()->latest()->limit(5)->get();

        $histories = $user->histories()->with('snack')->latest()->limit(5)->get();

        $userStats = [
            'sehat'           => $user->snacks()->where('hasil_klasifikasi', 'Snack Sehat')->count(),
            'perlu_perhatian' => $user->snacks()->where('hasil_klasifikasi', 'Perlu Perhatian')->count(),
            'klaim_diragukan' => $user->snacks()->where('hasil_klasifikasi', 'Klaim Sehat Diragukan')->count(),
        ];

        return view('admin.users.show', compact('user', 'snacks', 'histories', 'userStats'));
    }

    // ── Edit ───────────────────────────────────────────────────────────────────
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // ── Update ─────────────────────────────────────────────────────────────────
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'  => 'required|in:admin,user',
        ]);

        // Cegah admin mengubah role dirinya sendiri
        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'Anda tidak dapat mengubah role akun sendiri.');
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "Data user <strong>{$user->name}</strong> berhasil diperbarui.");
    }

    // ── Destroy ────────────────────────────────────────────────────────────────
    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "User <strong>{$name}</strong> berhasil dihapus.");
    }

    // ── Update Role (AJAX-friendly) ────────────────────────────────────────────
    public function updateRole(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa mengubah role akun sendiri.');
        }

        $request->validate(['role' => 'required|in:admin,user']);
        $user->update(['role' => $request->role]);

        return back()->with('success', "Role <strong>{$user->name}</strong> diubah menjadi {$request->role}.");
    }

    // ── Toggle Aktif/Nonaktif ─────────────────────────────────────────────────
    public function toggle(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun <strong>{$user->name}</strong> berhasil {$status}.");
    }
}