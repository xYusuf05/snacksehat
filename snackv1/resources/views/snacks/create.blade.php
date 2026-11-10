@extends('layouts.app')
@section('title', 'Tambah Snack')
@section('page-title', 'Tambah Snack Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="stat-icon" style="background:#eff6ff;color:#2563eb;">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div>
                    <h5 class="fw-700 mb-0">Input Data Snack</h5>
                    <p class="text-body-secondary mb-0" style="font-size:.8rem;">
                        Data akan otomatis diklasifikasikan menggunakan CART
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('snacks.store') }}">
                @csrf

                {{-- Nama Produk --}}
                <div class="mb-3">
                    <label class="form-label fw-500">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="nama_produk"
                           class="form-control @error('nama_produk') is-invalid @enderror"
                           value="{{ old('nama_produk') }}"
                           placeholder="Contoh: Oat Bar Almond">
                    @error('nama_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kandungan Gizi --}}
                <p class="fw-600 mb-2" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;color:var(--bs-secondary);">
                    Kandungan Gizi per 100g
                </p>

                <div class="row g-3 mb-4">
                    {{-- Gula --}}
                    <div class="col-6">
                        <label class="form-label fw-500">
                            Gula <span class="text-danger">*</span>
                            <span class="badge bg-perlu ms-1" style="font-size:.65rem;">g</span>
                        </label>
                        <input type="number" name="gula" step="0.01" min="0" max="100"
                               class="form-control @error('gula') is-invalid @enderror"
                               value="{{ old('gula') }}" placeholder="0.00">
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
                               value="{{ old('natrium') }}" placeholder="0.00">
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
                               value="{{ old('lemak') }}" placeholder="0.00">
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
                               value="{{ old('serat') }}" placeholder="0.00">
                        <div class="form-text">Sehat: ≥ 3g</div>
                        @error('serat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Preview estimasi (real-time) --}}
                <div id="previewBadge" class="alert border-0 rounded-3 mb-4 d-none py-2 px-3" style="font-size:.85rem;">
                    <i class="bi bi-cpu me-2"></i>
                    Estimasi: <strong id="previewResult">–</strong>
                    <small class="ms-1 text-body-secondary">(rule-based preview)</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cpu me-1"></i> Klasifikasikan
                    </button>
                    <a href="{{ route('snacks.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>

        {{-- Info box aturan klasifikasi --}}
        <div class="stat-card mt-3">
            <h6 class="fw-600 mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Aturan Klasifikasi CART</h6>
            <div class="row g-2">
                <div class="col-12">
                    <div class="p-2 rounded-2" style="background:#d1fae5;font-size:.8rem;">
                        <span class="badge bg-sehat me-2">Snack Sehat</span>
                        Gula ≤5g <b>DAN</b> Lemak ≤3g <b>DAN</b> Natrium ≤140mg <b>DAN</b> Serat ≥3g
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-2 rounded-2" style="background:#fee2e2;font-size:.8rem;">
                        <span class="badge bg-diragukan me-2">Klaim Diragukan</span>
                        (Gula >10g <b>DAN</b> Lemak >8g) <b>ATAU</b> Natrium >300mg
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-2 rounded-2" style="background:#fef3c7;font-size:.8rem;">
                        <span class="badge bg-perlu me-2">Perlu Perhatian</span>
                        Selain kondisi di atas
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Real-time rule-based preview
const fields   = ['gula','natrium','lemak','serat'];
const preview  = document.getElementById('previewBadge');
const result   = document.getElementById('previewResult');

function updatePreview() {
    const g = parseFloat(document.querySelector('[name=gula]').value)    || null;
    const n = parseFloat(document.querySelector('[name=natrium]').value) || null;
    const l = parseFloat(document.querySelector('[name=lemak]').value)   || null;
    const s = parseFloat(document.querySelector('[name=serat]').value)   || null;

    if ([g,n,l,s].some(v => v === null)) { preview.classList.add('d-none'); return; }

    let label, bgColor;
    if (g <= 5 && l <= 3 && n <= 140 && s >= 3) {
        label = 'Snack Sehat'; bgColor = '#d1fae5';
    } else if ((g > 10 && l > 8) || n > 300) {
        label = 'Klaim Sehat Diragukan'; bgColor = '#fee2e2';
    } else {
        label = 'Perlu Perhatian'; bgColor = '#fef3c7';
    }

    result.textContent      = label;
    preview.style.background = bgColor;
    preview.classList.remove('d-none');
}

fields.forEach(f => document.querySelector(`[name=${f}]`).addEventListener('input', updatePreview));
</script>
@endpush