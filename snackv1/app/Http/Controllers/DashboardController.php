<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Snack;
use App\Models\User;
use App\Services\ClassifierService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private ClassifierService $classifier) {}

    public function index()
    {
        $user      = Auth::user();
        $isAdmin   = $user->isAdmin();

        // ── Statistik snack (sesuai role) ──────────────────────────────────────
        $snackQuery = Snack::query();
        if (!$isAdmin) {
            $snackQuery->ownedBy($user->id);
        }

        $stats = [
            'total'           => (clone $snackQuery)->count(),
            'sehat'           => (clone $snackQuery)->sehat()->count(),
            'perlu_perhatian' => (clone $snackQuery)->perluPerhatian()->count(),
            'klaim_diragukan' => (clone $snackQuery)->klaimDiragukan()->count(),
        ];

        // ── Statistik tambahan khusus Admin ────────────────────────────────────
        $adminStats = null;
        if ($isAdmin) {
            $adminStats = [
                'total_users'        => User::count(),
                'total_admin'        => User::where('role', 'admin')->count(),
                'total_user'         => User::where('role', 'user')->count(),
                'user_aktif'         => User::where('is_active', true)->count(),
                'user_nonaktif'      => User::where('is_active', false)->count(),
                'total_klasifikasi'  => History::count(),
                'klasifikasi_hari_ini' => History::whereDate('created_at', today())->count(),
            ];
        }

        // ── Chart data (donut) ─────────────────────────────────────────────────
        $chartData = [
            'labels' => ['Snack Sehat', 'Perlu Perhatian', 'Klaim Sehat Diragukan'],
            'values' => [
                $stats['sehat'],
                $stats['perlu_perhatian'],
                $stats['klaim_diragukan'],
            ],
            'colors' => ['#198754', '#ffc107', '#dc3545'],
        ];

        // ── Trend 6 bulan (line chart) ─────────────────────────────────────────
        $trendData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $base  = Snack::whereMonth('created_at', $month->month)
                          ->whereYear('created_at',  $month->year);

            if (!$isAdmin) {
                $base->ownedBy($user->id);
            }

            $trendData[] = [
                'label'   => $month->translatedFormat('M Y'),
                'sehat'   => (clone $base)->sehat()->count(),
                'lainnya' => (clone $base)->where('hasil_klasifikasi', '!=', 'Snack Sehat')->count(),
            ];
        }

        // ── Riwayat terbaru (sesuai role) ──────────────────────────────────────
        $historyQuery = History::with('snack', 'user');
        if (!$isAdmin) {
            $historyQuery->where('user_id', $user->id);
        }
        $latestHistories = $historyQuery->latest()->limit(10)->get();

        // ── Top user aktif (khusus admin) ──────────────────────────────────────
        $topUsers = null;
        if ($isAdmin) {
            $topUsers = User::withCount('histories')
                ->orderByDesc('histories_count')
                ->limit(5)
                ->get();
        }

        $apiHealthy = $this->classifier->isHealthy();

        // ── Peringatan Konsumsi Mingguan (7 Hari Terakhir) ─────────────────────
        $weeklyAlerts = [];
        $startOfWeek = now()->subDays(7);
        $weeklySnacks = Snack::where('user_id', $user->id)
            ->where('created_at', '>=', $startOfWeek)
            ->get();
            
        $weeklyGula = $weeklySnacks->sum('gula');
        $weeklyNatrium = $weeklySnacks->sum('natrium');
        $weeklyLemak = $weeklySnacks->sum('lemak');
        
        // Batas Kemenkes RI per hari: Gula 50g, Natrium 2000mg, Lemak 67g. 
        // Maka per minggu (7 hari): Gula 350g, Natrium 14000mg, Lemak 469g.
        if ($weeklyGula > 350) {
            $weeklyAlerts[] = "Konsumsi gula Anda dalam 7 hari terakhir mencapai <strong>" . rtrim(rtrim(number_format($weeklyGula, 2, ',', '.'), '0'), ',') . "g</strong>, melebihi batas aman mingguan (350g). Kurangi konsumsi makanan dan minuman manis!";
        }
        if ($weeklyNatrium > 14000) {
            $weeklyAlerts[] = "Konsumsi natrium/garam Anda dalam 7 hari terakhir mencapai <strong>" . rtrim(rtrim(number_format($weeklyNatrium, 2, ',', '.'), '0'), ',') . "mg</strong>, melebihi batas aman mingguan (14.000mg). Kurangi makanan asin dan berpengawet!";
        }
        if ($weeklyLemak > 469) {
            $weeklyAlerts[] = "Konsumsi lemak Anda dalam 7 hari terakhir mencapai <strong>" . rtrim(rtrim(number_format($weeklyLemak, 2, ',', '.'), '0'), ',') . "g</strong>, melebihi batas aman mingguan (469g). Perhatikan asupan makanan berminyak atau gorengan!";
        }

        return view('dashboard', compact(
            'stats', 'adminStats', 'chartData', 'trendData',
            'latestHistories', 'topUsers', 'apiHealthy', 'isAdmin', 'weeklyAlerts'
        ));
    }
}