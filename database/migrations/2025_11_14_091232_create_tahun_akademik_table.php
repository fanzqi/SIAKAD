<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->id();

            // Tahun akademik seperti 2024/2025
            $table->string('tahun_akademik', 9);

            // Kode semester seperti 20241 / 20242 / 20243
            $table->string('kode_semester', 10);

            // Semester: ganjil, genap, pendek
            $table->enum('semester', ['Ganjil', 'Genap', 'Pendek']);

            // Semester ke (1-14)
            $table->integer('semester_ke');

            // Periode tanggal
            $table->date('periode_mulai');
            $table->date('periode_selesai');

            // Status
            $table->enum('status', ['aktif','nonaktif','ditutup'])->default('nonaktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tahun_akademik');
    }
};
