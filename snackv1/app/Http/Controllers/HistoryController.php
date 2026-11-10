<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = History::with('snack', 'user');

        // User hanya lihat riwayat sendiri, Admin lihat semua
        if (Auth::user()->isUser()) {
            $query->where('user_id', Auth::id());
        }

        if ($hasil = $request->get('hasil')) {
            $query->where('hasil', $hasil);
        }

        if ($search = $request->get('search')) {
            $query->whereHas('snack', fn($q) =>
                $q->where('nama_produk', 'like', "%{$search}%")
            );
        }

        $histories = $query->latest()->paginate(15)->withQueryString();

        // Statistik sesuai role
        $statsQuery = History::query();
        if (Auth::user()->isUser()) {
            $statsQuery->where('user_id', Auth::id());
        }

        $stats = [
            'total'           => (clone $statsQuery)->count(),
            'sehat'           => (clone $statsQuery)->where('hasil', 'Snack Sehat')->count(),
            'perlu_perhatian' => (clone $statsQuery)->where('hasil', 'Perlu Perhatian')->count(),
            'klaim_diragukan' => (clone $statsQuery)->where('hasil', 'Klaim Sehat Diragukan')->count(),
        ];

        return view('histories.index', compact('histories', 'stats'));
    }

    // ── Show ───────────────────────────────────────────────────────────────────
    public function show(History $history)
    {
        // User hanya bisa lihat riwayat milik sendiri
        if (Auth::user()->isUser() && $history->user_id !== Auth::id()) {
            abort(403);
        }

        $history->load('snack', 'user');
        return view('histories.show', compact('history'));
    }

    // ── Destroy ────────────────────────────────────────────────────────────────
    public function destroy(History $history)
    {
        // User hanya bisa hapus riwayat sendiri, Admin bisa hapus semua
        if (Auth::user()->isUser() && $history->user_id !== Auth::id()) {
            abort(403);
        }

        $history->delete();

        return redirect()->route('histories.index')
            ->with('success', 'Riwayat berhasil dihapus.');
    }
}