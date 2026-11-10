<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1e293b;
            padding: 20px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 2px solid #0f172a;
        }
        .header h1 { font-size: 18px; font-weight: bold; color: #0f172a; }
        .header p  { font-size: 10px; color: #64748b; margin-top: 4px; }

        /* Summary boxes */
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 16px;
        }
        .summary-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 10px 6px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .summary-item + .summary-item { margin-left: 6px; }
        .summary-num { font-size: 20px; font-weight: bold; }
        .summary-lbl { font-size: 9px; color: #64748b; margin-top: 2px; }
        .color-total  { color: #2563eb; }
        .color-sehat  { color: #16a34a; }
        .color-perlu  { color: #d97706; }
        .color-ragukan{ color: #dc2626; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        thead tr {
            background: #0f172a;
            color: #ffffff;
        }
        th {
            padding: 8px 6px;
            text-align: center;
            font-weight: bold;
        }
        th:first-child { text-align: left; padding-left: 10px; }
        td {
            padding: 7px 6px;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
        }
        td:first-child  { text-align: left; padding-left: 10px; }
        td:nth-child(2) { text-align: left; }
        tr:nth-child(even) { background: #f8fafc; }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-sehat    { background: #dcfce7; color: #166534; }
        .badge-perlu    { background: #fef9c3; color: #854d0e; }
        .badge-diragukan{ background: #fee2e2; color: #991b1b; }

        /* Footer */
        .footer {
            margin-top: 16px;
            font-size: 9px;
            color: #94a3b8;
            text-align: right;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>LAPORAN DATA SNACK – SNACKCHECK</h1>
        <p>Aplikasi Klaim Snack Sehat menggunakan Decision Tree Analysis (CART) &nbsp;|&nbsp; Dicetak: {{ now()->format('d M Y, H:i') }}</p>
    </div>

    {{-- Summary --}}
    @php
        $total    = $snacks->count();
        $sehat    = $snacks->where('hasil_klasifikasi', 'Snack Sehat')->count();
        $perlu    = $snacks->where('hasil_klasifikasi', 'Perlu Perhatian')->count();
        $diragukan= $snacks->where('hasil_klasifikasi', 'Klaim Sehat Diragukan')->count();
    @endphp
    <div class="summary">
        <div class="summary-item">
            <div class="summary-num color-total">{{ $total }}</div>
            <div class="summary-lbl">Total Snack</div>
        </div>
        <div class="summary-item">
            <div class="summary-num color-sehat">{{ $sehat }}</div>
            <div class="summary-lbl">Snack Sehat</div>
        </div>
        <div class="summary-item">
            <div class="summary-num color-perlu">{{ $perlu }}</div>
            <div class="summary-lbl">Perlu Perhatian</div>
        </div>
        <div class="summary-item">
            <div class="summary-num color-ragukan">{{ $diragukan }}</div>
            <div class="summary-lbl">Klaim Diragukan</div>
        </div>
    </div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th style="width:30px;">No</th>
                <th>Nama Produk</th>
                <th>Gula (g)</th>
                <th>Natrium (mg)</th>
                <th>Lemak (g)</th>
                <th>Serat (g)</th>
                <th>Klasifikasi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($snacks as $i => $snack)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $snack->nama_produk }}</td>
                <td>{{ $snack->gula }}</td>
                <td>{{ $snack->natrium }}</td>
                <td>{{ $snack->lemak }}</td>
                <td>{{ $snack->serat }}</td>
                <td>
                    @if($snack->hasil_klasifikasi === 'Snack Sehat')
                        <span class="badge badge-sehat">Snack Sehat</span>
                    @elseif($snack->hasil_klasifikasi === 'Perlu Perhatian')
                        <span class="badge badge-perlu">Perlu Perhatian</span>
                    @else
                        <span class="badge badge-diragukan">Klaim Diragukan</span>
                    @endif
                </td>
                <td>{{ $snack->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:20px; color:#94a3b8;">
                    Tidak ada data.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        SnackCheck – Decision Tree CART &nbsp;|&nbsp; Total: {{ $total }} data
    </div>

</body>
</html>