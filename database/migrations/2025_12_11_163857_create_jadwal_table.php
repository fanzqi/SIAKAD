<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            // ===== kolom fakultas & prodi =====
            $table->unsignedBigInteger('fakultas_id')
                  ->nullable()
                  ->after('semester');

            $table->unsignedBigInteger('program_studi_id')
                  ->nullable()
                  ->after('fakultas_id');

            // ===== kolom status Warek 1 (TAMBAHAN) =====
            $table->enum('status', ['draft','diajukan','disetujui','revisi'])
                  ->default('draft')
                  ->after('program_studi_id');

            $table->text('catatan_warek')
                  ->nullable()
                  ->after('status');

            $table->timestamp('tanggal_persetujuan')
                  ->nullable()
                  ->after('catatan_warek');

            // ===== foreign key =====
            $table->foreign('fakultas_id')
                  ->references('id')
                  ->on('fakultas')
                  ->onDelete('set null');

            $table->foreign('program_studi_id')
                  ->references('id')
                  ->on('program_studi')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            // drop foreign key
            $table->dropForeign(['fakultas_id']);
            $table->dropForeign(['program_studi_id']);

            // drop kolom Warek
            $table->dropColumn([
                'status',
                'catatan_warek',
                'tanggal_persetujuan'
            ]);

            // drop kolom fakultas & prodi
            $table->dropColumn([
                'fakultas_id',
                'program_studi_id'
            ]);
        });
    }
};