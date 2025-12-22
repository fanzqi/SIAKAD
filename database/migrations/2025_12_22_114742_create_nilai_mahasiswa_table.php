<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nilai_mahasiswa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mahasiswa_id')
                ->constrained('mahasiswa')
                ->cascadeOnDelete();

            $table->foreignId('mata_kuliah_id')
                ->constrained('mata_kuliah')
                ->cascadeOnDelete();

            $table->foreignId('dosen_id')
                ->constrained('dosen')
                ->cascadeOnDelete();

            $table->decimal('kehadiran', 5, 2)->default(0);
            $table->decimal('tugas', 5, 2)->default(0);
            $table->decimal('uts', 5, 2)->default(0);
            $table->decimal('uas', 5, 2)->default(0);

            $table->decimal('nilai_akhir', 5, 2)->default(0);
            $table->string('grade', 2)->nullable();
            $table->decimal('bobot', 3, 2)->nullable();

            $table->timestamps();

            $table->unique(['mahasiswa_id', 'mata_kuliah_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_mahasiswa');
    }
};
