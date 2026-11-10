<?php

namespace Database\Seeders;

use App\Models\Snack;
use Illuminate\Database\Seeder;

class SnackSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ── Snack Sehat ────────────────────────────────────────────────────
            ['nama_produk' => 'Oat Biscuit Almond',      'gula' => 3,  'natrium' => 90,  'lemak' => 2,  'serat' => 4],
            ['nama_produk' => 'Granola Bar Madu',         'gula' => 4,  'natrium' => 80,  'lemak' => 2,  'serat' => 5],
            ['nama_produk' => 'Rice Cake Rumput Laut',    'gula' => 2,  'natrium' => 110, 'lemak' => 1,  'serat' => 3],
            ['nama_produk' => 'Kacang Almond Panggang',   'gula' => 1,  'natrium' => 70,  'lemak' => 5,  'serat' => 3],
            ['nama_produk' => 'Crackers Gandum Utuh',     'gula' => 3,  'natrium' => 120, 'lemak' => 2,  'serat' => 4],
            ['nama_produk' => 'Buah Kering Aprikot',      'gula' => 5,  'natrium' => 30,  'lemak' => 0,  'serat' => 4],
            ['nama_produk' => 'Popcorn Tanpa Garam',      'gula' => 2,  'natrium' => 50,  'lemak' => 2,  'serat' => 3],
            ['nama_produk' => 'Keripik Tempe Panggang',   'gula' => 2,  'natrium' => 100, 'lemak' => 3,  'serat' => 4],
            ['nama_produk' => 'Edamame Kering',           'gula' => 1,  'natrium' => 60,  'lemak' => 3,  'serat' => 5],
            ['nama_produk' => 'Kacang Mete Unsalted',     'gula' => 2,  'natrium' => 40,  'lemak' => 4,  'serat' => 2],
            ['nama_produk' => 'Oat Bar Coklat Hitam',     'gula' => 4,  'natrium' => 95,  'lemak' => 3,  'serat' => 4],
            ['nama_produk' => 'Crackers Biji Chia',       'gula' => 3,  'natrium' => 105, 'lemak' => 2,  'serat' => 5],
            ['nama_produk' => 'Snack Kacang Hijau',       'gula' => 2,  'natrium' => 85,  'lemak' => 2,  'serat' => 4],
            ['nama_produk' => 'Biskuit Oat Raisin',       'gula' => 5,  'natrium' => 100, 'lemak' => 2,  'serat' => 3],
            ['nama_produk' => 'Keripik Kale Panggang',    'gula' => 1,  'natrium' => 80,  'lemak' => 2,  'serat' => 3],
            ['nama_produk' => 'Rice Bar Multigrain',      'gula' => 4,  'natrium' => 115, 'lemak' => 2,  'serat' => 4],
            ['nama_produk' => 'Trail Mix Rendah Gula',    'gula' => 3,  'natrium' => 70,  'lemak' => 4,  'serat' => 3],
            ['nama_produk' => 'Pea Crisps Original',      'gula' => 2,  'natrium' => 130, 'lemak' => 2,  'serat' => 4],
            ['nama_produk' => 'Protein Bar Vanila',       'gula' => 5,  'natrium' => 140, 'lemak' => 3,  'serat' => 3],
            ['nama_produk' => 'Dark Chocolate 85%',       'gula' => 4,  'natrium' => 10,  'lemak' => 5,  'serat' => 3],

            // ── Perlu Perhatian ─────────────────────────────────────────────────
            ['nama_produk' => 'Wafer Coklat Susu',        'gula' => 8,  'natrium' => 150, 'lemak' => 6,  'serat' => 1],
            ['nama_produk' => 'Biskuit Cream Sandwich',   'gula' => 9,  'natrium' => 160, 'lemak' => 7,  'serat' => 1],
            ['nama_produk' => 'Keripik Kentang BBQ',      'gula' => 7,  'natrium' => 200, 'lemak' => 8,  'serat' => 2],
            ['nama_produk' => 'Snack Jagung Manis',       'gula' => 6,  'natrium' => 170, 'lemak' => 5,  'serat' => 2],
            ['nama_produk' => 'Kerupuk Udang',            'gula' => 7,  'natrium' => 220, 'lemak' => 5,  'serat' => 1],
            ['nama_produk' => 'Biscuit Kelapa',           'gula' => 8,  'natrium' => 140, 'lemak' => 6,  'serat' => 2],
            ['nama_produk' => 'Rice Cracker Wasabi',      'gula' => 6,  'natrium' => 190, 'lemak' => 4,  'serat' => 2],
            ['nama_produk' => 'Snack Kacang Pedas',       'gula' => 7,  'natrium' => 210, 'lemak' => 6,  'serat' => 2],
            ['nama_produk' => 'Pretzel Original',         'gula' => 8,  'natrium' => 230, 'lemak' => 4,  'serat' => 2],
            ['nama_produk' => 'Cracker Keju Cheddar',     'gula' => 7,  'natrium' => 180, 'lemak' => 6,  'serat' => 1],
            ['nama_produk' => 'Stick Keju',               'gula' => 9,  'natrium' => 200, 'lemak' => 7,  'serat' => 1],
            ['nama_produk' => 'Tortilla Chips',           'gula' => 8,  'natrium' => 195, 'lemak' => 7,  'serat' => 2],
            ['nama_produk' => 'Pop Corn Karamel',         'gula' => 9,  'natrium' => 160, 'lemak' => 6,  'serat' => 2],
            ['nama_produk' => 'Wafer Stroberi',           'gula' => 8,  'natrium' => 130, 'lemak' => 6,  'serat' => 1],
            ['nama_produk' => 'Snack Bola Keju',          'gula' => 7,  'natrium' => 220, 'lemak' => 7,  'serat' => 1],
            ['nama_produk' => 'Minichips Coklat Susu',    'gula' => 9,  'natrium' => 140, 'lemak' => 7,  'serat' => 1],
            ['nama_produk' => 'Corn Puff Keju',           'gula' => 7,  'natrium' => 230, 'lemak' => 6,  'serat' => 1],
            ['nama_produk' => 'Snack Beras Panggang',     'gula' => 6,  'natrium' => 175, 'lemak' => 5,  'serat' => 2],
            ['nama_produk' => 'Biscuit Susu Madu',        'gula' => 8,  'natrium' => 145, 'lemak' => 6,  'serat' => 1],
            ['nama_produk' => 'Crackers Ayam',            'gula' => 7,  'natrium' => 215, 'lemak' => 6,  'serat' => 1],

            // ── Klaim Sehat Diragukan ───────────────────────────────────────────
            ['nama_produk' => 'Choco Pie',                'gula' => 14, 'natrium' => 200, 'lemak' => 12, 'serat' => 0],
            ['nama_produk' => 'Keripik Kentang Sour Cream','gula'=> 12, 'natrium' => 350, 'lemak' => 15, 'serat' => 1],
            ['nama_produk' => 'Permen Coklat Filling',    'gula' => 15, 'natrium' => 180, 'lemak' => 14, 'serat' => 0],
            ['nama_produk' => 'Wafer Fla Coklat Super',   'gula' => 13, 'natrium' => 220, 'lemak' => 13, 'serat' => 0],
            ['nama_produk' => 'Snack Ring Bawang',        'gula' => 11, 'natrium' => 310, 'lemak' => 11, 'serat' => 1],
            ['nama_produk' => 'Cheese Ball XXL',          'gula' => 12, 'natrium' => 380, 'lemak' => 14, 'serat' => 0],
            ['nama_produk' => 'Coklat Karamel Nougat',    'gula' => 16, 'natrium' => 150, 'lemak' => 13, 'serat' => 0],
            ['nama_produk' => 'Keripik Ekstra Pedas',     'gula' => 11, 'natrium' => 400, 'lemak' => 12, 'serat' => 1],
            ['nama_produk' => 'Snack Goreng Ayam',        'gula' => 13, 'natrium' => 350, 'lemak' => 15, 'serat' => 0],
            ['nama_produk' => 'Corn Dog Mini',            'gula' => 12, 'natrium' => 320, 'lemak' => 12, 'serat' => 0],
        ];

        // Klasifikasi rule-based untuk seeder (tidak butuh API aktif)
        foreach ($data as $row) {
            $g = $row['gula']; $n = $row['natrium'];
            $l = $row['lemak']; $s = $row['serat'];

            if ($g <= 5 && $l <= 3 && $n <= 140 && $s >= 3) {
                $klasifikasi = 'Snack Sehat';
            } elseif (($g > 10 && $l > 8) || $n > 300) {
                $klasifikasi = 'Klaim Sehat Diragukan';
            } else {
                $klasifikasi = 'Perlu Perhatian';
            }

            Snack::create([...$row, 'hasil_klasifikasi' => $klasifikasi]);
        }

        $this->command->info('✅ 50 data snack berhasil di-seed!');
    }
}