<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->string('nidn', 20)->unique();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email', 100)->unique();
            $table->string('telepon', 20)->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('fakultas_id')->nullable();
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('fakultas_id')->references('id')->on('fakultas')->onDelete('set null');
            $table->foreign('prodi_id')->references('id')->on('prodi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
