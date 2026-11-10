@extends('layouts.app')
@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h5 class="fw-700 mb-0">{{ $user->name }}</h5>
            <p class="text-body-secondary mb-0" style="font-size:.8rem;">{{ $user->email }}</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

{{-- ── Info & Status ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="text-body-secondary" style="font-size:.75rem;">Role</div>
            <span class="badge rounded-pill {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }} mt-1">
                {{ ucfirst($user->role) }}
            </span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="text-body-secondary" style="font-size:.75rem;">Status Akun</div>
            <span class="badge rounded-pill {{ $user->is_active ? 'bg-sehat' : 'bg-diragukan' }} mt-1">
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="text-body-secondary" style="font-size:.75rem;">Total Snack Diinput</div>
            <div class="fw-700 fs-4">{{ $user->snacks_count }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="text-body-secondary" style="font-size:.75rem;">Total Klasifikasi</div>
            <div class="fw-700 fs-4">{{ $user->histories_count }}</div>
        </div>
    </div>
</div>

{{-- ── Distribusi Hasil Klasifikasi ── --}}
<div class="stat-card mb-4">
    <div class="fw-600 mb-3" style="font-size:.9rem;">Distribusi Hasil Klasifikasi</div>
    <div class="row g-3 text-center">
        <div class="col-4">
            <span class="badge rounded-pill bg-sehat px-3 py-2">Snack Sehat</span>
            <div class="fw-700 fs-5 mt-1">{{ $userStats['sehat'] }}</div>
        </div>
        <div class="col-4">
            <span class="badge rounded-pill bg-perlu px-3 py-2">Perlu Perhatian</span>
            <div class="fw-700 fs-5 mt-1">{{ $userStats['perlu_perhatian'] }}</div>
        </div>
        <div class="col-4">
            <span class="badge rounded-pill bg-diragukan px-3 py-2">Klaim Diragukan</span>
            <div class="fw-700 fs-5 mt-1">{{ $userStats['klaim_diragukan'] }}</div>
        </div>
    </div>
</div>

{{-- ── Snack Terbaru ── --}}
<div class="stat-card p-0 overflow-hidden mb-4">
    <div class="px-4 py-3 border-bottom fw-600" style="font-size:.9rem;">5 Snack Terakhir Diinput</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
            <thead>
                <tr style="background:var(--bs-tertiary-bg);">
                    <th class="ps-4">Nama Produk</th>
                    <th class="text-center">Klasifikasi</th>
                    <th class="text-center pe-4">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($snacks as $snack)
                <tr>
                    <td class="ps-4">{{ $snack->nama_produk }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill
                            @if($snack->hasil_klasifikasi === 'Snack Sehat') bg-sehat
                            @elseif($snack->hasil_klasifikasi === 'Perlu Perhatian') bg-perlu
                            @else bg-diragukan @endif">
                            {{ $snack->hasil_klasifikasi }}
                        </span>
                    </td>
                    <td class="text-center pe-4 text-body-secondary">{{ $snack->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-4 text-body-secondary">Belum ada data snack.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Riwayat Terbaru ── --}}
<div class="stat-card p-0 overflow-hidden">
    <div class="px-4 py-3 border-bottom fw-600" style="font-size:.9rem;">5 Riwayat Klasifikasi Terakhir</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
            <thead>
                <tr style="background:var(--bs-tertiary-bg);">
                    <th class="ps-4">Snack</th>
                    <th class="text-center">Hasil</th>
                    <th class="text-center pe-4">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                <tr>
                    <td class="ps-4">{{ $history->snack->nama_produk ?? '-' }}</td>
                    <td class="text-center">{{ $history->hasil }}</td>
                    <td class="text-center pe-4 text-body-secondary">{{ $history->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-4 text-body-secondary">Belum ada riwayat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
