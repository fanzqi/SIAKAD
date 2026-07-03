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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('mata_kuliah_id')
                ->constrained('mata_kuliah')
                ->cascadeOnDelete();

            $table->foreignId('ruangs_id')
                ->constrained('ruangs')
                ->cascadeOnDelete();

            $table->foreignId('dosen_id')
                ->nullable()
                ->constrained('dosen')
                ->nullOnDelete();

            $table->string('semester');
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            // Fakultas & program_studi
            $table->foreignId('fakultas_id')
                ->nullable()
                ->constrained('fakultas')
                ->nullOnDelete();

            $table->foreignId('program_studi_id')
                ->nullable()
                ->constrained('program_studi')
                ->nullOnDelete();

            // Status Persetujuan
            $table->enum('status', [
                'draft',
                'diajukan',
                'disetujui',
                'revisi'
            ])->default('draft');

            $table->text('catatan_warek')->nullable();

            $table->timestamp('tanggal_persetujuan')->nullable();

            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};