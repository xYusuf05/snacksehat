<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Snack;
use App\Services\ClassifierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SnacksExport;

class SnackController extends Controller
{
    public function __construct(private ClassifierService $classifier) {}

    // ── Index ──────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Snack::with('user');

        // Admin lihat semua, User hanya milik sendiri
        if (Auth::user()->isUser()) {
            $query->ownedBy(Auth::id());
        }

        if ($search = $request->get('search')) {
            $query->where('nama_produk', 'like', "%{$search}%");
        }

        if ($kategori = $request->get('kategori')) {
            $query->where('hasil_klasifikasi', $kategori);
        }

        $snacks = $query->latest()->paginate(10)->withQueryString();

        return view('snacks.index', compact('snacks'));
    }

    // ── Create ─────────────────────────────────────────────────────────────────
    public function create()
    {
        return view('snacks.create');
    }

    // ── Store ──────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gula'        => 'required|numeric|min:0|max:100',
            'natrium'     => 'required|numeric|min:0|max:5000',
            'lemak'       => 'required|numeric|min:0|max:100',
            'serat'       => 'required|numeric|min:0|max:100',
        ]);

        $result = $this->classifier->predict(
            $validated['gula'],
            $validated['natrium'],
            $validated['lemak'],
            $validated['serat'],
        );

        $snack = Snack::create([
            ...$validated,
            'user_id'           => Auth::id(),
            'hasil_klasifikasi' => $result['hasil'],
            'method'            => $result['method'] ?? 'Unknown',
        ]);

        History::create([
            'snack_id'     => $snack->id,
            'user_id'      => Auth::id(),
            'hasil'        => $result['hasil'],
            'detail_input' => [
                'gula'    => $validated['gula'],
                'natrium' => $validated['natrium'],
                'lemak'   => $validated['lemak'],
                'serat'   => $validated['serat'],
            ],
            'confidence' => $result['confidence'] ?? null,
            'method'     => $result['method'] ?? 'Unknown',
        ]);

        $method = $result['method'] ?? 'Unknown';
        return redirect()->route('snacks.show', $snack)
            ->with('success', "Snack berhasil diklasifikasikan sebagai: <strong>{$result['hasil']}</strong> (Metode: {$method})");
    }

    // ── Show ───────────────────────────────────────────────────────────────────
    public function show(Snack $snack)
    {
        // User hanya bisa lihat milik sendiri
        if (Auth::user()->isUser() && $snack->user_id !== Auth::id()) {
            abort(403);
        }

        $snack->load('histories.user', 'user');
        return view('snacks.show', compact('snack'));
    }

    // ── Edit ───────────────────────────────────────────────────────────────────
    public function edit(Snack $snack)
    {
        if (Auth::user()->isUser() && $snack->user_id !== Auth::id()) {
            abort(403);
        }

        return view('snacks.edit', compact('snack'));
    }

    // ── Update ─────────────────────────────────────────────────────────────────
    public function update(Request $request, Snack $snack)
    {
        if (Auth::user()->isUser() && $snack->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gula'        => 'required|numeric|min:0|max:100',
            'natrium'     => 'required|numeric|min:0|max:5000',
            'lemak'       => 'required|numeric|min:0|max:100',
            'serat'       => 'required|numeric|min:0|max:100',
        ]);

        $result = $this->classifier->predict(
            $validated['gula'],
            $validated['natrium'],
            $validated['lemak'],
            $validated['serat'],
        );

        $snack->update([
            ...$validated,
            'hasil_klasifikasi' => $result['hasil'],
            'method'            => $result['method'] ?? 'Unknown',
        ]);

        History::create([
            'snack_id'     => $snack->id,
            'user_id'      => Auth::id(),
            'hasil'        => $result['hasil'],
            'detail_input' => [
                'gula'    => $validated['gula'],
                'natrium' => $validated['natrium'],
                'lemak'   => $validated['lemak'],
                'serat'   => $validated['serat'],
            ],
            'confidence' => $result['confidence'] ?? null,
            'method'     => $result['method'] ?? 'Unknown',
        ]);

        $method = $result['method'] ?? 'Unknown';
        return redirect()->route('snacks.show', $snack)
            ->with('success', "Data diperbarui. Hasil klasifikasi baru: <strong>{$result['hasil']}</strong> (Metode: {$method})");
    }

    // ── Destroy ────────────────────────────────────────────────────────────────
    public function destroy(Snack $snack)
    {
        // User hanya bisa hapus milik sendiri, Admin bisa hapus semua
        if (Auth::user()->isUser() && $snack->user_id !== Auth::id()) {
            abort(403);
        }

        $snack->delete();

        return redirect()->route('snacks.index')
            ->with('success', 'Data snack berhasil dihapus.');
    }

    // ── Export PDF ─────────────────────────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $query = Snack::query();

        // User hanya export datanya sendiri
        if (Auth::user()->isUser()) {
            $query->ownedBy(Auth::id());
        }

        $snacks = $query
            ->when($request->kategori, fn($q, $k) => $q->where('hasil_klasifikasi', $k))
            ->latest()->get();

        $pdf = Pdf::loadView('snacks.pdf', compact('snacks'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-snack-' . now()->format('Ymd') . '.pdf');
    }

    // ── Export Excel ───────────────────────────────────────────────────────────
    public function exportExcel()
    {
        $userId = Auth::user()->isUser() ? Auth::id() : null;
        return Excel::download(
            new SnacksExport(null, $userId),
            'data-snack-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ── Statistik AJAX ─────────────────────────────────────────────────────────
    public function statistik()
    {
        $query = Snack::query();

        if (Auth::user()->isUser()) {
            $query->ownedBy(Auth::id());
        }

        return response()->json([
            'total'           => (clone $query)->count(),
            'sehat'           => (clone $query)->sehat()->count(),
            'perlu_perhatian' => (clone $query)->perluPerhatian()->count(),
            'klaim_diragukan' => (clone $query)->klaimDiragukan()->count(),
        ]);
    }
}