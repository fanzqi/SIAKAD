<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->string('alamat')->nullable();
            $table->year('angkatan')->nullable();
            $table->unsignedBigInteger('tahun_akademik_id')->nullable();
            $table->unsignedBigInteger('kurikulum_id')->nullable();
            $table->string('status')->default('Aktif');
            $table->string('foto')->nullable();

            $table->unsignedBigInteger('user_id')->nullable(); // RELASI UTAMA DENGAN USERS
            $table->unsignedBigInteger('fakultas_id')->nullable();
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->unsignedBigInteger('semester_aktif_id')->nullable();
            $table->unsignedBigInteger('grup_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key (jika tabel lain ada)
            $table->foreign('tahun_akademik_id')->references('id')->on('tahun_akademik')->nullOnDelete();
            $table->foreign('kurikulum_id')->references('id')->on('kurikulums')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('fakultas_id')->references('id')->on('fakultas')->nullOnDelete();
            $table->foreign('prodi_id')->references('id')->on('program_studi')->nullOnDelete();
            $table->foreign('semester_aktif_id')->references('id')->on('semester')->nullOnDelete();
            $table->foreign('grup_id')->references('id')->on('grup')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
