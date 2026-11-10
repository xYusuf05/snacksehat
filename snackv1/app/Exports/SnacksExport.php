<?php

namespace App\Exports;

use App\Models\Snack;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SnacksExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(
        private ?string $kategori = null,
        private ?int    $userId   = null,
    ) {}

    public function query()
    {
        return Snack::query()
            ->when($this->userId,    fn($q) => $q->where('user_id', $this->userId))
            ->when($this->kategori,  fn($q) => $q->where('hasil_klasifikasi', $this->kategori))
            ->latest();
    }

    public function title(): string
    {
        return 'Data Snack';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Produk',
            'Gula (g)',
            'Natrium (mg)',
            'Lemak (g)',
            'Serat (g)',
            'Hasil Klasifikasi',
            'Tanggal Input',
        ];
    }

    public function map($snack): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $snack->nama_produk,
            $snack->gula,
            $snack->natrium,
            $snack->lemak,
            $snack->serat,
            $snack->hasil_klasifikasi ?? 'Belum Diklasifikasi',
            $snack->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Header row styling
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0F172A'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}