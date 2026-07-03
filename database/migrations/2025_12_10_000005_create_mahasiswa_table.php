<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {

            $table->id();

            $table->string('nim')->unique();
            $table->string('nama');

            $table->enum('jenis_kelamin',['L','P']);

            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();

            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();

            $table->year('angkatan')->nullable();

            $table->string('status')->default('Aktif');
            $table->string('foto')->nullable();

            // Login
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Fakultas
            $table->foreignId('fakultas_id')
                  ->nullable()
                  ->constrained('fakultas')
                  ->nullOnDelete();

            // Prodi
            $table->foreignId('prodi_id')
                  ->nullable()
                  ->constrained('program_studi')
                  ->nullOnDelete();

            // Kurikulum
            $table->foreignId('kurikulum_id')
                  ->nullable()
                  ->constrained('kurikulums')
                  ->nullOnDelete();

            // Tahun akademik
            $table->foreignId('tahun_akademik_id')
                  ->nullable()
                  ->constrained('tahun_akademik')
                  ->nullOnDelete();

            // Semester aktif
            $table->foreignId('semester_aktif_id')
                  ->nullable()
                  ->references('id')
                  ->on('tahun_akademik')
                  ->nullOnDelete();

            // Grup (belum dibuat FK)
            $table->unsignedBigInteger('grup_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
