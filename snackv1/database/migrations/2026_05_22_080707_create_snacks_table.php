<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('snacks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->decimal('gula',    5, 2)->comment('gram per 100g');
            $table->decimal('natrium', 6, 2)->comment('mg per 100g');
            $table->decimal('lemak',   5, 2)->comment('gram per 100g');
            $table->decimal('serat',   5, 2)->comment('gram per 100g');
            $table->enum('hasil_klasifikasi', [
                'Snack Sehat',
                'Perlu Perhatian',
                'Klaim Sehat Diragukan',
            ])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snacks');
    }
};