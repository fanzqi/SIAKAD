<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {

            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nidn', 20)->unique();
            $table->string('nama', 100);

            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->text('alamat')->nullable();

            $table->string('email', 100)->unique();
            $table->string('telepon', 20)->nullable();

            $table->enum('status', ['Aktif', 'Tidak Aktif'])
                ->default('Aktif');

            $table->string('foto')->nullable();

            // Relasi Fakultas
            $table->foreignId('fakultas_id')
                ->nullable()
                ->constrained('fakultas')
                ->nullOnDelete();

            // Relasi Program Studi
            $table->foreignId('program_studi_id')
                ->nullable()
                ->constrained('program_studi')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
