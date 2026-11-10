<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('snack_id')
                  ->constrained('snacks')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->enum('hasil', [
                'Snack Sehat',
                'Perlu Perhatian',
                'Klaim Sehat Diragukan',
            ]);
            $table->json('detail_input')->nullable()
                  ->comment('Snapshot nilai gizi saat klasifikasi');
            $table->json('confidence')->nullable()
                  ->comment('Probabilitas tiap kelas dari model');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};