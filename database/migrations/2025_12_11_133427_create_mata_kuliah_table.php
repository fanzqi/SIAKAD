<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();

            $table->string('kode')->unique();
            $table->string('nama_mata_kuliah');
            $table->unsignedTinyInteger('sks');

            // relasi
            $table->foreignId('dosen_id')
                ->nullable()
                ->constrained('dosen')
                ->nullOnDelete();

            $table->foreignId('fakultas_id')
                ->nullable()
                ->constrained('fakultas')
                ->nullOnDelete();

            $table->foreignId('program_studi_id')
                ->nullable()
                ->constrained('program_studi')
                ->nullOnDelete();

            // semester dan group
            $table->unsignedTinyInteger('semester');
            $table->string('group',10)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};