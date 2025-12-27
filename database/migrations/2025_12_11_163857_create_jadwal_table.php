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
            if (!Schema::hasColumn('jadwal', 'fakultas_id')) {
                $table->unsignedBigInteger('fakultas_id')
                      ->nullable()
                      ->after('semester');
                $table->foreign('fakultas_id')
                      ->references('id')
                      ->on('fakultas')
                      ->onDelete('set null');
            }

            if (!Schema::hasColumn('jadwal', 'program_studi_id')) {
                $table->unsignedBigInteger('program_studi_id')
                      ->nullable()
                      ->after('fakultas_id');
                $table->foreign('program_studi_id')
                      ->references('id')
                      ->on('program_studi')
                      ->onDelete('set null');
            }

            // ===== kolom status Warek 1 =====
            if (!Schema::hasColumn('jadwal', 'status')) {
                $table->enum('status', ['draft','diajukan','disetujui','revisi'])
                      ->default('draft')
                      ->after('program_studi_id');
            }

            // ===== kolom catatan Warek =====
            if (!Schema::hasColumn('jadwal', 'catatan_warek')) {
                $table->text('catatan_warek')
                      ->nullable()
                      ->after('status');
            }

            // ===== kolom tanggal persetujuan =====
            if (!Schema::hasColumn('jadwal', 'tanggal_persetujuan')) {
                $table->timestamp('tanggal_persetujuan')
                      ->nullable()
                      ->after('catatan_warek');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            // drop foreign key dulu sebelum kolom
            if (Schema::hasColumn('jadwal', 'fakultas_id')) {
                $table->dropForeign(['fakultas_id']);
            }
            if (Schema::hasColumn('jadwal', 'program_studi_id')) {
                $table->dropForeign(['program_studi_id']);
            }

            // drop kolom Warek
            if (Schema::hasColumn('jadwal', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('jadwal', 'catatan_warek')) {
                $table->dropColumn('catatan_warek');
            }
            if (Schema::hasColumn('jadwal', 'tanggal_persetujuan')) {
                $table->dropColumn('tanggal_persetujuan');
            }

            // drop kolom fakultas & prodi
            if (Schema::hasColumn('jadwal', 'fakultas_id')) {
                $table->dropColumn('fakultas_id');
            }
            if (Schema::hasColumn('jadwal', 'program_studi_id')) {
                $table->dropColumn('program_studi_id');
            }
        });
    }
};