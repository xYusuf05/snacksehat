@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-700 mb-0">Edit User</h5>
        <p class="text-body-secondary mb-0" style="font-size:.8rem;">{{ $user->name }}</p>
    </div>
</div>

@if($user->id === auth()->id())
<div class="alert alert-warning border-0 rounded-3 mb-3" style="font-size:.85rem;">
    <i class="bi bi-info-circle me-2"></i>
    Anda sedang mengedit akun sendiri. Role dan status aktif akun sendiri tidak dapat diubah demi keamanan sistem.
</div>
@endif

<div class="row g-3">
    <div class="col-lg-7">
        <div class="stat-card">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" style="font-size:.85rem;">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size:.85rem;">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" style="font-size:.85rem;">Role</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror"
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="user"  {{ old('role', $user->role) === 'user'  ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @if($user->id === auth()->id())
                        {{-- kirim value asli tetap tersimpan meski select disabled --}}
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <div class="form-text">Tidak dapat mengubah role akun sendiri.</div>
                    @endif
                    @error('role') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="stat-card">
            <div class="fw-600 mb-3" style="font-size:.9rem;">Status Akun</div>
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-body-secondary" style="font-size:.85rem;">Status saat ini</span>
                <span class="badge rounded-pill {{ $user->is_active ? 'bg-sehat' : 'bg-diragukan' }}">
                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-outline-warning w-100">
                        <i class="bi {{ $user->is_active ? 'bi-toggle-off' : 'bi-toggle-on' }} me-1"></i>
                        {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                    </button>
                </form>
            @else
                <button type="button" class="btn btn-outline-secondary w-100" disabled>
                    <i class="bi bi-lock me-1"></i> Tidak dapat menonaktifkan akun sendiri
                </button>
            @endif
        </div>
    </div>
</div>

@endsection
