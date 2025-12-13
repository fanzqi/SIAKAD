<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel mata_kuliah
            $table->foreignId('mata_kuliah_id')
                  ->constrained('mata_kuliah')
                  ->onDelete('cascade');

            // Foreign key ke tabel ruangs
            $table->foreignId('ruangs_id')
                  ->constrained('ruangs')
                  ->onDelete('cascade');

            $table->string('semester');      // misal "Ganjil 2025/2026"
            $table->string('hari');          // misal "Senin"
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
