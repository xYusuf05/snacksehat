@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit Data User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="stat-card">

            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="stat-icon" style="background:#fff7ed;color:#ea580c;">
                    <i class="bi bi-person-gear"></i>
                </div>
                <div>
                    <h5 class="fw-700 mb-0">Edit User</h5>
                    <p class="text-body-secondary mb-0" style="font-size:.8rem;">
                        {{ $user->email }}
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-500">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-500">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-500">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="user"  {{ old('role', $user->role) === 'user'  ? 'selected' : '' }}>
                            User – Akses data milik sendiri
                        </option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                            Admin – Akses semua data & manajemen user
                        </option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection