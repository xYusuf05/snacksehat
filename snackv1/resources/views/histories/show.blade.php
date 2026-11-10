@extends('layouts.app')
@section('title', 'Detail Riwayat Klasifikasi')
@section('page-title', 'Detail Riwayat Klasifikasi')

@section('content')

@php
    $badgeClass = match($history->hasil) {
        'Snack Sehat'           => 'bg-sehat',
        'Perlu Perhatian'       => 'bg-perlu',
        'Klaim Sehat Diragukan' => 'bg-diragukan',
        default                 => 'bg-secondary',
    };
    $input = $history->detail_input ?? [];
    $confidence = $history->confidence ?? [];
@endphp

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('histories.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-700 mb-0">{{ $history->snack->nama_produk ?? 'Data snack telah dihapus' }}</h5>
        <p class="text-body-secondary mb-0" style="font-size:.8rem;">
            Diklasifikasikan {{ $history->created_at->translatedFormat('d M Y, H:i') }} WIB
        </p>
    </div>
</div>

<div class="row g-3">

    {{-- ── Hasil Klasifikasi ── --}}
    <div class="col-lg-4">
        <div class="stat-card text-center py-4">
            <div class="text-body-secondary mb-2" style="font-size:.8rem;">Hasil Klasifikasi</div>
            <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2 mb-3" style="font-size:.95rem;">
                {{ $history->hasil }}
            </span>

            @if(!empty($confidence))
            <div class="text-start mt-3">
                <div class="text-body-secondary mb-2" style="font-size:.75rem;">Tingkat Keyakinan Model</div>
                @foreach($confidence as $label => $percent)
                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-1" style="font-size:.78rem;">
                        <span>{{ $label }}</span>
                        <span class="fw-600">{{ $percent }}%</span>
                    </div>
                    <div class="progress" style="height:6px;border-radius:99px;">
                        <div class="progress-bar" style="width:{{ $percent }}%;
                             background:{{ $label === $history->hasil ? '#22d3ee' : '#cbd5e1' }};border-radius:99px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <hr class="my-3">

            <div class="text-start" style="font-size:.8rem;">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-body-secondary">Diinput oleh</span>
                    <span class="fw-500">{{ $history->user->name ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-body-secondary">Metode</span>
                    <span class="fw-500">CART Decision Tree</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Detail Nilai Gizi ── --}}
    <div class="col-lg-8">
        <div class="stat-card mb-3">
            <h6 class="fw-600 mb-3">Snapshot Nilai Gizi Saat Klasifikasi</h6>
            <div class="row g-3 text-center">
                <div class="col-6 col-md-3">
                    <div class="p-3 rounded-3" style="background:var(--bs-tertiary-bg);">
                        <div class="text-body-secondary" style="font-size:.72rem;">Gula</div>
                        <div class="fw-700 fs-5">{{ $input['gula'] ?? '-' }}<span style="font-size:.7rem;"> g</span></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 rounded-3" style="background:var(--bs-tertiary-bg);">
                        <div class="text-body-secondary" style="font-size:.72rem;">Natrium</div>
                        <div class="fw-700 fs-5">{{ $input['natrium'] ?? '-' }}<span style="font-size:.7rem;"> mg</span></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 rounded-3" style="background:var(--bs-tertiary-bg);">
                        <div class="text-body-secondary" style="font-size:.72rem;">Lemak</div>
                        <div class="fw-700 fs-5">{{ $input['lemak'] ?? '-' }}<span style="font-size:.7rem;"> g</span></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 rounded-3" style="background:var(--bs-tertiary-bg);">
                        <div class="text-body-secondary" style="font-size:.72rem;">Serat</div>
                        <div class="fw-700 fs-5">{{ $input['serat'] ?? '-' }}<span style="font-size:.7rem;"> g</span></div>
                    </div>
                </div>
            </div>
        </div>

        @if($history->snack)
        <div class="stat-card mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-600 mb-0">Data Snack Terkait</h6>
                <a href="{{ route('snacks.show', $history->snack) }}" class="btn btn-sm btn-outline-primary" style="font-size:.78rem;">
                    Lihat Detail Snack <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <p class="text-body-secondary mb-0" style="font-size:.85rem;">
                Data nilai gizi saat ini pada snack <strong>{{ $history->snack->nama_produk }}</strong> mungkin
                sudah berbeda dari snapshot riwayat ini apabila datanya pernah diubah setelah klasifikasi dilakukan.
            </p>
        </div>
        @endif

        <div class="d-flex gap-2">
            <form method="POST" action="{{ route('histories.destroy', $history) }}"
                  onsubmit="return confirm('Yakin ingin menghapus riwayat ini?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash me-1"></i> Hapus Riwayat
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
