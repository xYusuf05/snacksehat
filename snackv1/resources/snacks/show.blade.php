@extends('layouts.app')
@section('title', $snack->nama_produk)
@section('page-title', 'Detail Snack')

@section('content')
<div class="row g-3">

    {{-- ── Info Utama ── --}}
    <div class="col-lg-5">
        <div class="stat-card h-100">
            <div class="d-flex align-items-start justify-content-between mb-4">
                <div>
                    <h4 class="fw-700 mb-1">{{ $snack->nama_produk }}</h4>
                    <span class="badge rounded-pill fs-6
                        @if($snack->hasil_klasifikasi === 'Snack Sehat') bg-sehat
                        @elseif($snack->hasil_klasifikasi === 'Perlu Perhatian') bg-perlu
                        @else bg-diragukan @endif">
                        @if($snack->hasil_klasifikasi === 'Snack Sehat')
                            <i class="bi bi-heart-pulse me-1"></i>
                        @elseif($snack->hasil_klasifikasi === 'Perlu Perhatian')
                            <i class="bi bi-exclamation-circle me-1"></i>
                        @else
                            <i class="bi bi-shield-x me-1"></i>
                        @endif
                        {{ $snack->hasil_klasifikasi }}
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('snacks.edit', $snack) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
            </div>

            {{-- Radar Gizi --}}
            <canvas id="radarChart" height="220"></canvas>
        </div>
    </div>

    {{-- ── Nilai Gizi ── --}}
    <div class="col-lg-7">
        <div class="stat-card mb-3">
            <h6 class="fw-600 mb-3">Kandungan Gizi (per 100g)</h6>

            @php
            $nutrients = [
                ['label' => 'Gula',    'value' => $snack->gula,    'unit' => 'g',  'limit' => 5,   'max' => 20,  'good' => 'low'],
                ['label' => 'Natrium', 'value' => $snack->natrium, 'unit' => 'mg', 'limit' => 140, 'max' => 500, 'good' => 'low'],
                ['label' => 'Lemak',   'value' => $snack->lemak,   'unit' => 'g',  'limit' => 3,   'max' => 20,  'good' => 'low'],
                ['label' => 'Serat',   'value' => $snack->serat,   'unit' => 'g',  'limit' => 3,   'max' => 10,  'good' => 'high'],
            ];
            @endphp

            @foreach($nutrients as $n)
            @php
                $pct = min(100, ($n['value'] / $n['max']) * 100);
                $isGood = ($n['good'] === 'low')
                    ? $n['value'] <= $n['limit']
                    : $n['value'] >= $n['limit'];
                $barColor = $isGood ? '#198754' : ($n['value'] <= $n['limit'] * 1.5 ? '#ffc107' : '#dc3545');
            @endphp
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span class="fw-500" style="font-size:.875rem;">{{ $n['label'] }}</span>
                    <span class="fw-600" style="font-size:.875rem;">
                        {{ $n['value'] }} {{ $n['unit'] }}
                        @if($isGood)
                        <i class="bi bi-check-circle-fill text-success ms-1" style="font-size:.8rem;"></i>
                        @else
                        <i class="bi bi-exclamation-circle-fill text-danger ms-1" style="font-size:.8rem;"></i>
                        @endif
                    </span>
                </div>
                <div class="progress" style="height:8px; border-radius:99px;">
                    <div class="progress-bar" style="width:{{ $pct }}%; background:{{ $barColor }}; border-radius:99px;"></div>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span class="text-body-secondary" style="font-size:.7rem;">0</span>
                    <span class="text-body-secondary" style="font-size:.7rem;">
                        Batas {{ $n['good'] === 'low' ? 'max' : 'min' }}: {{ $n['limit'] }}{{ $n['unit'] }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Meta --}}
        <div class="stat-card" style="font-size:.875rem;">
            <div class="row g-2">
                <div class="col-6">
                    <span class="text-body-secondary">Ditambahkan</span><br>
                    <strong>{{ $snack->created_at->format('d M Y, H:i') }}</strong>
                </div>
                <div class="col-6">
                    <span class="text-body-secondary">Terakhir diperbarui</span><br>
                    <strong>{{ $snack->updated_at->diffForHumans() }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Riwayat Klasifikasi ── --}}
    <div class="col-12">
        <div class="stat-card">
            <h6 class="fw-600 mb-3">Riwayat Klasifikasi Snack Ini</h6>
            <div class="table-responsive">
                <table class="table align-middle" style="font-size:.875rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th><th>Oleh</th><th>Gula</th><th>Natrium</th><th>Lemak</th><th>Serat</th><th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($snack->histories as $h)
                        <tr>
                            <td>{{ $h->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $h->user->name ?? '-' }}</td>
                            <td>{{ $h->detail_input['gula'] ?? '-' }}g</td>
                            <td>{{ $h->detail_input['natrium'] ?? '-' }}mg</td>
                            <td>{{ $h->detail_input['lemak'] ?? '-' }}g</td>
                            <td>{{ $h->detail_input['serat'] ?? '-' }}g</td>
                            <td>
                                <span class="badge rounded-pill
                                    @if($h->hasil === 'Snack Sehat') bg-sehat
                                    @elseif($h->hasil === 'Perlu Perhatian') bg-perlu
                                    @else bg-diragukan @endif">
                                    {{ $h->hasil }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-body-secondary">Tidak ada riwayat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels: ['Gula', 'Natrium\n(/100)', 'Lemak', 'Serat'],
        datasets: [{
            label: '{{ $snack->nama_produk }}',
            data: [
                {{ $snack->gula }},
                {{ round($snack->natrium / 10, 1) }},
                {{ $snack->lemak }},
                {{ $snack->serat }}
            ],
            borderColor: '#22d3ee',
            backgroundColor: 'rgba(34,211,238,.15)',
            pointBackgroundColor: '#22d3ee',
            borderWidth: 2,
        }]
    },
    options: {
        scales: {
            r: {
                beginAtZero: true,
                ticks: { display: false },
                grid: { color: 'rgba(0,0,0,.08)' },
            }
        },
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush