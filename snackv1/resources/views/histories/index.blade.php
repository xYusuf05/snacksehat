@extends('layouts.app')
@section('title', 'Riwayat Klasifikasi')
@section('page-title', 'Riwayat Klasifikasi')

@section('content')

{{-- ── Stat Mini ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card text-center py-3">
            <div class="fs-3 fw-700">{{ $stats['total'] }}</div>
            <div class="text-body-secondary" style="font-size:.78rem;">Total Riwayat</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center py-3">
            <div class="fs-3 fw-700 text-success">{{ $stats['sehat'] }}</div>
            <div class="text-body-secondary" style="font-size:.78rem;">Snack Sehat</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center py-3">
            <div class="fs-3 fw-700 text-warning">{{ $stats['perlu_perhatian'] }}</div>
            <div class="text-body-secondary" style="font-size:.78rem;">Perlu Perhatian</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center py-3">
            <div class="fs-3 fw-700 text-danger">{{ $stats['klaim_diragukan'] }}</div>
            <div class="text-body-secondary" style="font-size:.78rem;">Klaim Diragukan</div>
        </div>
    </div>
</div>

{{-- ── Filter ── --}}
<div class="stat-card mb-3">
    <form method="GET" class="row g-2">
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-body-secondary"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                       placeholder="Cari nama produk..."
                       value="{{ request('search') }}" id="searchInput">
            </div>
        </div>
        <div class="col-md-4">
            <select name="hasil" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Hasil</option>
                <option value="Snack Sehat"           {{ request('hasil') === 'Snack Sehat' ? 'selected' : '' }}>Snack Sehat</option>
                <option value="Perlu Perhatian"        {{ request('hasil') === 'Perlu Perhatian' ? 'selected' : '' }}>Perlu Perhatian</option>
                <option value="Klaim Sehat Diragukan"  {{ request('hasil') === 'Klaim Sehat Diragukan' ? 'selected' : '' }}>Klaim Sehat Diragukan</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary btn-sm w-100">Filter</button>
        </div>
    </form>
</div>

{{-- ── Tabel ── --}}
<div class="stat-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.875rem;">
            <thead>
                <tr style="background:var(--bs-tertiary-bg);">
                    <th class="ps-4 py-3">#</th>
                    <th>Nama Produk</th>
                    <th class="text-center">Gula</th>
                    <th class="text-center">Natrium</th>
                    <th class="text-center">Lemak</th>
                    <th class="text-center">Serat</th>
                    <th class="text-center">Hasil</th>
                    <th>Pengguna</th>
                    <th>Waktu</th>
                    <th class="pe-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $i => $h)
                <tr>
                    <td class="ps-4 text-body-secondary">{{ $histories->firstItem() + $i }}</td>
                    <td class="fw-500">
                        @if($h->snack)
                            <a href="{{ route('snacks.show', $h->snack) }}" class="text-decoration-none">
                                {{ $h->snack->nama_produk }}
                            </a>
                        @else
                            <span class="text-body-secondary fst-italic">Snack dihapus</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $h->detail_input['gula'] ?? '–' }}g</td>
                    <td class="text-center">{{ $h->detail_input['natrium'] ?? '–' }}mg</td>
                    <td class="text-center">{{ $h->detail_input['lemak'] ?? '–' }}g</td>
                    <td class="text-center">{{ $h->detail_input['serat'] ?? '–' }}g</td>
                    <td class="text-center">
                        <span class="badge rounded-pill
                            @if($h->hasil === 'Snack Sehat') bg-sehat
                            @elseif($h->hasil === 'Perlu Perhatian') bg-perlu
                            @else bg-diragukan @endif">
                            {{ $h->hasil }}
                        </span>
                    </td>
                    <td class="text-body-secondary" style="font-size:.8rem;">
                        {{ $h->user->name ?? '–' }}
                    </td>
                    <td class="text-body-secondary" style="font-size:.8rem;" title="{{ $h->created_at->format('d M Y H:i') }}">
                        {{ $h->created_at->diffForHumans() }}
                    </td>
                    <td class="text-center pe-4">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('histories.show', $h) }}"
                               class="btn btn-xs btn-outline-secondary py-0 px-2" title="Detail">
                                <i class="bi bi-eye" style="font-size:.85rem;"></i>
                            </a>
                            <button class="btn btn-xs btn-outline-danger py-0 px-2" title="Hapus"
                                    onclick="confirmDelete({{ $h->id }})">
                                <i class="bi bi-trash" style="font-size:.85rem;"></i>
                            </button>
                        </div>
                        <form id="del-{{ $h->id }}" method="POST"
                              action="{{ route('histories.destroy', $h) }}" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5 text-body-secondary">
                        <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                        Belum ada riwayat klasifikasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($histories->hasPages())
    <div class="px-4 py-3 border-top">
        {{ $histories->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Yakin ingin menghapus riwayat ini?')) {
        document.getElementById('del-' + id).submit();
    }
}

let searchTimer;
document.getElementById('searchInput').addEventListener('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => this.closest('form').submit(), 400);
});
</script>
@endpush