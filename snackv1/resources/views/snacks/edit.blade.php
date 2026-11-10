@extends('layouts.app')
@section('title', 'Edit Snack')
@section('page-title', 'Edit Data Snack')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="stat-icon" style="background:#fff7ed;color:#ea580c;">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <h5 class="fw-700 mb-0">Edit: {{ $snack->nama_produk }}</h5>
                    <p class="text-body-secondary mb-0" style="font-size:.8rem;">
                        Data akan diklasifikasikan ulang setelah disimpan
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('snacks.update', $snack) }}">
                @csrf
                @method('PUT')

                {{-- Nama Produk --}}
                <div class="mb-3">
                    <label class="form-label fw-500">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="nama_produk"
                           class="form-control @error('nama_produk') is-invalid @enderror"
                           value="{{ old('nama_produk', $snack->nama_produk) }}"
                           placeholder="Contoh: Oat Bar Almond">
                    @error('nama_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Label gizi --}}
                <p class="fw-600 mb-2" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;color:var(--bs-secondary);">
                    Kandungan Gizi per 100g
                </p>

                {{-- Klasifikasi sekarang --}}
                <div class="alert border-0 rounded-3 mb-3 py-2 px-3" style="
                    background:{{ $snack->hasil_klasifikasi === 'Snack Sehat' ? '#d1fae5' : ($snack->hasil_klasifikasi === 'Perlu Perhatian' ? '#fef3c7' : '#fee2e2') }};
                    font-size:.85rem;">
                    <i class="bi bi-tag me-2"></i>
                    Klasifikasi saat ini: <strong>{{ $snack->hasil_klasifikasi }}</strong>
                </div>

                <div class="row g-3 mb-4">
                    {{-- Gula --}}
                    <div class="col-6">
                        <label class="form-label fw-500">
                            Gula <span class="text-danger">*</span>
                            <span class="badge bg-perlu ms-1" style="font-size:.65rem;">g</span>
                        </label>
                        <input type="number" name="gula" step="0.01" min="0" max="100"
                               class="form-control @error('gula') is-invalid @enderror"
                               value="{{ old('gula', $snack->gula) }}" placeholder="0.00">
                        <div class="form-text">Sehat: ≤ 5g</div>
                        @error('gula')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Natrium --}}
                    <div class="col-6">
                        <label class="form-label fw-500">
                            Natrium <span class="text-danger">*</span>
                            <span class="badge bg-perlu ms-1" style="font-size:.65rem;">mg</span>
                        </label>
                        <input type="number" name="natrium" step="0.01" min="0" max="5000"
                               class="form-control @error('natrium') is-invalid @enderror"
                               value="{{ old('natrium', $snack->natrium) }}" placeholder="0.00">
                        <div class="form-text">Sehat: ≤ 140mg</div>
                        @error('natrium')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Lemak --}}
                    <div class="col-6">
                        <label class="form-label fw-500">
                            Lemak <span class="text-danger">*</span>
                            <span class="badge bg-perlu ms-1" style="font-size:.65rem;">g</span>
                        </label>
                        <input type="number" name="lemak" step="0.01" min="0" max="100"
                               class="form-control @error('lemak') is-invalid @enderror"
                               value="{{ old('lemak', $snack->lemak) }}" placeholder="0.00">
                        <div class="form-text">Sehat: ≤ 3g</div>
                        @error('lemak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Serat --}}
                    <div class="col-6">
                        <label class="form-label fw-500">
                            Serat <span class="text-danger">*</span>
                            <span class="badge bg-sehat ms-1" style="font-size:.65rem;">g</span>
                        </label>
                        <input type="number" name="serat" step="0.01" min="0" max="100"
                               class="form-control @error('serat') is-invalid @enderror"
                               value="{{ old('serat', $snack->serat) }}" placeholder="0.00">
                        <div class="form-text">Sehat: ≥ 3g</div>
                        @error('serat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Preview baru (real-time) --}}
                <div id="previewBadge" class="alert border-0 rounded-3 mb-4 py-2 px-3" style="font-size:.85rem; background:#f1f5f9;">
                    <i class="bi bi-arrow-repeat me-2"></i>
                    Estimasi baru: <strong id="previewResult">–</strong>
                    <small class="ms-1 text-body-secondary">(rule-based preview)</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-arrow-repeat me-1"></i> Perbarui & Klasifikasi Ulang
                    </button>
                    <a href="{{ route('snacks.show', $snack) }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const fields = ['gula','natrium','lemak','serat'];
const preview = document.getElementById('previewBadge');
const result  = document.getElementById('previewResult');

function updatePreview() {
    const g = parseFloat(document.querySelector('[name=gula]').value)    || null;
    const n = parseFloat(document.querySelector('[name=natrium]').value) || null;
    const l = parseFloat(document.querySelector('[name=lemak]').value)   || null;
    const s = parseFloat(document.querySelector('[name=serat]').value)   || null;

    if ([g,n,l,s].some(v => v === null)) {
        preview.style.background = '#f1f5f9';
        result.textContent = '–';
        return;
    }

    let label, bgColor;
    if (g <= 5 && l <= 3 && n <= 140 && s >= 3) {
        label = 'Snack Sehat'; bgColor = '#d1fae5';
    } else if ((g > 10 && l > 8) || n > 300) {
        label = 'Klaim Sehat Diragukan'; bgColor = '#fee2e2';
    } else {
        label = 'Perlu Perhatian'; bgColor = '#fef3c7';
    }

    result.textContent       = label;
    preview.style.background = bgColor;
}

fields.forEach(f => document.querySelector(`[name=${f}]`).addEventListener('input', updatePreview));
updatePreview(); // run on load
</script>
@endpush