@extends('layouts.app')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')

{{-- ── Header Bar ── --}}
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h5 class="fw-700 mb-0">Manajemen User</h5>
        <p class="text-body-secondary mb-0" style="font-size:.8rem;">
            {{ $users->total() }} akun terdaftar
        </p>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="text-body-secondary" style="font-size:.75rem;">Total User</div>
            <div class="fw-700 fs-4">{{ $stats['total'] }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="text-body-secondary" style="font-size:.75rem;">Admin</div>
            <div class="fw-700 fs-4">{{ $stats['admin'] }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="text-body-secondary" style="font-size:.75rem;">User Biasa</div>
            <div class="fw-700 fs-4">{{ $stats['user'] }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="text-body-secondary" style="font-size:.75rem;">Nonaktif</div>
            <div class="fw-700 fs-4 text-danger">{{ $stats['nonaktif'] }}</div>
        </div>
    </div>
</div>

{{-- ── Filter & Search ── --}}
<div class="stat-card mb-3">
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2">
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text border-end-0 bg-transparent">
                    <i class="bi bi-search text-body-secondary"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                       placeholder="Cari nama atau email..."
                       value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Snack</th>
                    <th class="text-center">Bergabung</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td class="ps-4 text-body-secondary">{{ $users->firstItem() + $i }}</td>
                    <td class="fw-500">
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                            <span class="badge bg-secondary-subtle text-secondary-emphasis" style="font-size:.65rem;">Anda</span>
                        @endif
                    </td>
                    <td class="text-body-secondary">{{ $user->email }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge rounded-pill {{ $user->is_active ? 'bg-sehat' : 'bg-diragukan' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="text-center">{{ $user->snacks_count }}</td>
                    <td class="text-center text-body-secondary">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-center pe-4">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-xs btn-outline-secondary py-0 px-2" title="Detail">
                                <i class="bi bi-eye" style="font-size:.85rem;"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-xs btn-outline-primary py-0 px-2" title="Edit">
                                <i class="bi bi-pencil" style="font-size:.85rem;"></i>
                            </a>

                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-xs btn-outline-warning py-0 px-2"
                                            title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="bi {{ $user->is_active ? 'bi-toggle-on' : 'bi-toggle-off' }}" style="font-size:.85rem;"></i>
                                    </button>
                                </form>
                                <button class="btn btn-xs btn-outline-danger py-0 px-2" title="Hapus"
                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                    <i class="bi bi-trash" style="font-size:.85rem;"></i>
                                </button>
                                <form id="delete-{{ $user->id }}" method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            @else
                                <span class="text-body-secondary" style="font-size:.7rem;" title="Tidak bisa mengubah/menghapus akun sendiri">
                                    <i class="bi bi-lock"></i>
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-body-secondary">
                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                        Belum ada user ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-4 py-3 border-top">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Yakin ingin menghapus user "${name}"? Tindakan ini tidak dapat dibatalkan.`)) {
        document.getElementById('delete-' + id).submit();
    }
}
</script>
@endpush
