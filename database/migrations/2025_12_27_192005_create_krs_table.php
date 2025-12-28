<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('krs', function (Blueprint $table) {
            // Tambah kolom id_tahun_akademik setelah kurikulum_id, nullable dulu biar mudah update
            $table->foreignId('id_tahun_akademik')
                  ->nullable()
                  ->after('kurikulum_id')
                  ->constrained('tahun_akademik')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('krs', function (Blueprint $table) {
            $table->dropForeign(['id_tahun_akademik']);
            $table->dropColumn('id_tahun_akademik');
        });
    }
};
