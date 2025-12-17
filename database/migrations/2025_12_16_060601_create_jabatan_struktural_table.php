<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jabatan_struktural', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
            $table->string('jabatan', 50);
            $table->enum('unit', ['Fakultas', 'Prodi', 'Rektorat', 'Lainnya'])->default('Fakultas');
            $table->date('mulai_jabatan');
            $table->date('selesai_jabatan')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan_struktural');
    }
};
