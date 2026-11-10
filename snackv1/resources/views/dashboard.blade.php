@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Status API (khusus admin) ── --}}
@if($isAdmin && !$apiHealthy)
<div class="alert border-0 rounded-3 mb-4" style="background:#fff7ed;color:#9a3412;">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>Python API tidak aktif.</strong> Klasifikasi menggunakan rule-based fallback.
    Jalankan: <code>python app.py</code> di folder <code>python-api</code>.
</div>
@endif

{{-- ── Greeting ── --}}
<div class="mb-4">
    <h5 class="fw-700 mb-0">
        Selamat datang, {{ Auth::user()->name }}!
        @if($isAdmin)
        <span class="badge ms-2 rounded-pill" style="background:rgba(99,102,241,.1);color:#6366f1;font-size:.7rem;">
            <i class="bi bi-shield-fill me-1"></i>Administrator
        </span>
        @endif
    </h5>
    <p class="text-body-secondary mb-0" style="font-size:.85rem;">
        @if($isAdmin)
            Berikut ringkasan seluruh data di sistem SnackCheck.
        @else
            Berikut ringkasan data snack milik Anda.
        @endif
    </p>
</div>

{{-- ── Peringatan Konsumsi Mingguan ── --}}
@if(isset($weeklyAlerts) && count($weeklyAlerts) > 0)
    <div class="mb-4">
        @foreach($weeklyAlerts as $alert)
        <div class="alert alert-warning border-0 rounded-3 shadow-sm d-flex align-items-center mb-2" style="background: #fff3cd; color: #856404;">
            <div class="me-3 fs-3" style="color: #ffc107;">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div>
                <strong class="d-block mb-1">Peringatan Konsumsi Berlebih!</strong>
                <span style="font-size: 0.9rem;">{!! $alert !!}</span>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- ── Stat Cards Tambahan Admin ── --}}
@if($isAdmin && $adminStats)
<div class="row g-3 mb-3">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary fw-500" style="font-size:.8rem;">Total User</span>
                <div class="stat-icon" style="background:rgba(99,102,241,.1);color:#6366f1;">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="fs-2 fw-700">{{ $adminStats['total_users'] }}</div>
            <div class="text-body-secondary" style="font-size:.75rem;">
                {{ $adminStats['total_admin'] }} admin · {{ $adminStats['total_user'] }} user
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary fw-500" style="font-size:.8rem;">User Aktif</span>
                <div class="stat-icon" style="background:#d1fae5;color:#065f46;">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
            <div class="fs-2 fw-700 text-success">{{ $adminStats['user_aktif'] }}</div>
            <div class="text-body-secondary" style="font-size:.75rem;">
                {{ $adminStats['user_nonaktif'] }} nonaktif
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary fw-500" style="font-size:.8rem;">Total Klasifikasi</span>
                <div class="stat-icon" style="background:#eff6ff;color:#2563eb;">
                    <i class="bi bi-cpu"></i>
                </div>
            </div>
            <div class="fs-2 fw-700">{{ $adminStats['total_klasifikasi'] }}</div>
            <div class="text-body-secondary" style="font-size:.75rem;">semua riwayat</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary fw-500" style="font-size:.8rem;">Klasifikasi Hari Ini</span>
                <div class="stat-icon" style="background:#fef3c7;color:#92400e;">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
            <div class="fs-2 fw-700 text-warning">{{ $adminStats['klasifikasi_hari_ini'] }}</div>
            <div class="text-body-secondary" style="font-size:.75rem;">{{ now()->format('d M Y') }}</div>
        </div>
    </div>
</div>
@endif

{{-- ── Stat Cards Snack ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary fw-500" style="font-size:.8rem;">
                    Total Snack {{ $isAdmin ? '' : 'Saya' }}
                </span>
                <div class="stat-icon" style="background:#eff6ff;color:#2563eb;">
                    <i class="bi bi-bag-check"></i>
                </div>
            </div>
            <div class="fs-2 fw-700">{{ $stats['total'] }}</div>
            <div class="text-body-secondary" style="font-size:.75rem;">data terdaftar</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary fw-500" style="font-size:.8rem;">Snack Sehat</span>
                <div class="stat-icon" style="background:#d1fae5;color:#065f46;">
                    <i class="bi bi-heart-pulse"></i>
                </div>
            </div>
            <div class="fs-2 fw-700 text-success">{{ $stats['sehat'] }}</div>
            <div class="text-body-secondary" style="font-size:.75rem;">
                {{ $stats['total'] > 0 ? round($stats['sehat'] / $stats['total'] * 100) : 0 }}% dari total
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary fw-500" style="font-size:.8rem;">Perlu Perhatian</span>
                <div class="stat-icon" style="background:#fef3c7;color:#92400e;">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
            </div>
            <div class="fs-2 fw-700 text-warning">{{ $stats['perlu_perhatian'] }}</div>
            <div class="text-body-secondary" style="font-size:.75rem;">
                {{ $stats['total'] > 0 ? round($stats['perlu_perhatian'] / $stats['total'] * 100) : 0 }}% dari total
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary fw-500" style="font-size:.8rem;">Klaim Diragukan</span>
                <div class="stat-icon" style="background:#fee2e2;color:#991b1b;">
                    <i class="bi bi-shield-x"></i>
                </div>
            </div>
            <div class="fs-2 fw-700 text-danger">{{ $stats['klaim_diragukan'] }}</div>
            <div class="text-body-secondary" style="font-size:.75rem;">
                {{ $stats['total'] > 0 ? round($stats['klaim_diragukan'] / $stats['total'] * 100) : 0 }}% dari total
            </div>
        </div>
    </div>
</div>

{{-- ── Charts ── --}}
<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="stat-card h-100">
            <h6 class="fw-600 mb-3">Distribusi Kategori</h6>
            <canvas id="pieChart" height="220"></canvas>
        </div>
    </div>
    <div class="col-lg-{{ $isAdmin && $topUsers ? '5' : '8' }}">
        <div class="stat-card h-100">
            <h6 class="fw-600 mb-3">Tren Klasifikasi (6 Bulan)</h6>
            <canvas id="trendChart" height="120"></canvas>
        </div>
    </div>

    {{-- Top Users (khusus admin) --}}
    @if($isAdmin && $topUsers)
    <div class="col-lg-3">
        <div class="stat-card h-100">
            <h6 class="fw-600 mb-3">User Teraktif</h6>
            @forelse($topUsers as $i => $u)
            <div class="d-flex align-items-center gap-2 mb-2 pb-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="fw-700 text-body-secondary" style="width:16px;font-size:.8rem;">{{ $i+1 }}</div>
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-700"
                     style="width:28px;height:28px;flex-shrink:0;font-size:.7rem;
                     background:{{ $u->isAdmin() ? 'rgba(99,102,241,.15)' : 'rgba(34,211,238,.15)' }};
                     color:{{ $u->isAdmin() ? '#6366f1' : '#22d3ee' }};">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="fw-500" style="font-size:.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $u->name }}
                    </div>
                    <div class="text-body-secondary" style="font-size:.7rem;">
                        {{ $u->histories_count }} klasifikasi
                    </div>
                </div>
            </div>
            @empty
            <p class="text-body-secondary text-center" style="font-size:.8rem;">Belum ada data.</p>
            @endforelse
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm w-100 mt-2" style="font-size:.78rem;">
                Lihat Semua User <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @endif
</div>

{{-- ── Riwayat Terbaru ── --}}
<div class="stat-card">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-600 mb-0">
            Riwayat Terbaru
            @if(!$isAdmin)
            <small class="text-body-secondary fw-400" style="font-size:.75rem;">(milik saya)</small>
            @endif
        </h6>
        <a href="{{ route('histories.index') }}" class="btn btn-sm" style="font-size:.78rem;">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle" style="font-size:.875rem;">
            <thead class="table-light">
                <tr>
                    <th>Nama Produk</th>
                    @if($isAdmin)<th>User</th>@endif
                    <th>Gula</th><th>Natrium</th><th>Lemak</th><th>Serat</th>
                    <th>Hasil</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestHistories as $h)
                <tr>
                    <td class="fw-500">{{ $h->snack->nama_produk ?? '–' }}</td>
                    @if($isAdmin)
                    <td class="text-body-secondary" style="font-size:.8rem;">{{ $h->user->name ?? '–' }}</td>
                    @endif
                    <td>{{ $h->detail_input['gula']    ?? '–' }}g</td>
                    <td>{{ $h->detail_input['natrium'] ?? '–' }}mg</td>
                    <td>{{ $h->detail_input['lemak']   ?? '–' }}g</td>
                    <td>{{ $h->detail_input['serat']   ?? '–' }}g</td>
                    <td>
                        <span class="badge rounded-pill
                            @if($h->hasil === 'Snack Sehat') bg-sehat
                            @elseif($h->hasil === 'Perlu Perhatian') bg-perlu
                            @else bg-diragukan @endif">
                            {{ $h->hasil }}
                        </span>
                    </td>
                    <td class="text-body-secondary">{{ $h->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $isAdmin ? 8 : 7 }}" class="text-center text-body-secondary py-4">
                        Belum ada riwayat klasifikasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
const chartData = @json($chartData);
const trendData = @json($trendData);

new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: chartData.labels,
        datasets: [{
            data: chartData.values,
            backgroundColor: chartData.colors,
            borderWidth: 0,
            hoverOffset: 6,
        }]
    },
    options: {
        cutout: '65%',
        plugins: { legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } } }
    }
});

new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: trendData.map(d => d.label),
        datasets: [
            {
                label: 'Snack Sehat',
                data: trendData.map(d => d.sehat),
                borderColor: '#198754', backgroundColor: 'rgba(25,135,84,.1)',
                tension: .4, fill: true, pointRadius: 4,
            },
            {
                label: 'Non-Sehat',
                data: trendData.map(d => d.lainnya),
                borderColor: '#dc3545', backgroundColor: 'rgba(220,53,69,.1)',
                tension: .4, fill: true, pointRadius: 4,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush