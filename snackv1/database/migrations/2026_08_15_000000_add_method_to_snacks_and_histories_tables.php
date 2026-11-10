<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('snacks', function (Blueprint $table) {
            $table->string('method')->nullable()->after('hasil_klasifikasi');
        });

        Schema::table('histories', function (Blueprint $table) {
            $table->string('method')->nullable()->after('confidence');
        });
    }

    public function down(): void
    {
        Schema::table('snacks', function (Blueprint $table) {
            $table->dropColumn('method');
        });

        Schema::table('histories', function (Blueprint $table) {
            $table->dropColumn('method');
        });
    }
};
