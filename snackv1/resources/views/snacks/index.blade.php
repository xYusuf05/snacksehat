@extends('layouts.app')
@section('title', 'Data Snack')
@section('page-title', 'Data Snack')

@section('content')

{{-- ── Header Bar ── --}}
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h5 class="fw-700 mb-0">Daftar Snack</h5>
        <p class="text-body-secondary mb-0" style="font-size:.8rem;">
            {{ $snacks->total() }} data ditemukan
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('snacks.export.pdf') }}" class="btn btn-sm btn-outline-danger" target="_blank">
            <i class="bi bi-file-pdf me-1"></i> PDF
        </a>
        <a href="{{ route('snacks.export.excel') }}" class="btn btn-sm btn-outline-success">
            <i class="bi bi-file-excel me-1"></i> Excel
        </a>
        <a href="{{ route('snacks.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </a>
    </div>
</div>

{{-- ── Filter & Search ── --}}
<div class="stat-card mb-3">
    <form method="GET" action="{{ route('snacks.index') }}" class="row g-2">
        <div class="col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-text border-end-0 bg-transparent">
                    <i class="bi bi-search text-body-secondary"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                       placeholder="Cari nama produk..."
                       value="{{ request('search') }}"
                       id="searchInput">
            </div>
        </div>
        <div class="col-md-4">
            <select name="kategori" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <option value="Snack Sehat"           {{ request('kategori') === 'Snack Sehat' ? 'selected' : '' }}>Snack Sehat</option>
                <option value="Perlu Perhatian"        {{ request('kategori') === 'Perlu Perhatian' ? 'selected' : '' }}>Perlu Perhatian</option>
                <option value="Klaim Sehat Diragukan"  {{ request('kategori') === 'Klaim Sehat Diragukan' ? 'selected' : '' }}>Klaim Sehat Diragukan</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
        </div>
    </form>
</div>

{{-- ── Tabel ── --}}
<div class="stat-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.875rem;">
            <thead>
                <tr style="background:var(--bs-tertiary-bg);">
                    <th class="ps-4 py-3" style="width:40px;">#</th>
                    <th>Nama Produk</th>
                    <th class="text-center">Gula<br><small class="text-body-secondary fw-400">(g)</small></th>
                    <th class="text-center">Natrium<br><small class="text-body-secondary fw-400">(mg)</small></th>
                    <th class="text-center">Lemak<br><small class="text-body-secondary fw-400">(g)</small></th>
                    <th class="text-center">Serat<br><small class="text-body-secondary fw-400">(g)</small></th>
                    <th class="text-center">Klasifikasi</th>
                    <th class="text-center">Metode</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($snacks as $i => $snack)
                <tr>
                    <td class="ps-4 text-body-secondary">{{ $snacks->firstItem() + $i }}</td>
                    <td class="fw-500">{{ $snack->nama_produk }}</td>
                    <td class="text-center">{{ $snack->gula }}</td>
                    <td class="text-center">{{ $snack->natrium }}</td>
                    <td class="text-center">{{ $snack->lemak }}</td>
                    <td class="text-center">{{ $snack->serat }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill
                            @if($snack->hasil_klasifikasi === 'Snack Sehat') bg-sehat
                            @elseif($snack->hasil_klasifikasi === 'Perlu Perhatian') bg-perlu
                            @else bg-diragukan @endif">
                            {{ $snack->hasil_klasifikasi ?? 'Belum diklasifikasi' }}
                        </span>
                    </td>
                    <td class="text-center text-body-secondary" style="font-size: .8rem;">
                        {{ $snack->method ?? 'Unknown' }}
                    </td>
                    <td class="text-center pe-4">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('snacks.show', $snack) }}" class="btn btn-xs btn-outline-secondary py-0 px-2" title="Detail">
                                <i class="bi bi-eye" style="font-size:.85rem;"></i>
                            </a>
                            <a href="{{ route('snacks.edit', $snack) }}" class="btn btn-xs btn-outline-primary py-0 px-2" title="Edit">
                                <i class="bi bi-pencil" style="font-size:.85rem;"></i>
                            </a>
                            <button class="btn btn-xs btn-outline-danger py-0 px-2" title="Hapus"
                                    onclick="confirmDelete({{ $snack->id }}, '{{ $snack->nama_produk }}')">
                                <i class="bi bi-trash" style="font-size:.85rem;"></i>
                            </button>
                        </div>
                        <form id="delete-{{ $snack->id }}" method="POST"
                              action="{{ route('snacks.destroy', $snack) }}" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-body-secondary">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada data snack.
                        <a href="{{ route('snacks.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($snacks->hasPages())
    <div class="px-4 py-3 border-top">
        {{ $snacks->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Yakin ingin menghapus "${name}"?`)) {
        document.getElementById('delete-' + id).submit();
    }
}

// Realtime search (debounce 400ms)
let searchTimer;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => this.closest('form').submit(), 400);
});
</script>
@endpush