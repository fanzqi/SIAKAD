<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('input_nilai', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tahun_akademik_id');
        $table->text('deskripsi');
        $table->date('tanggal_mulai');
        $table->date('tanggal_akhir');
        $table->enum('status', ['Aktif', 'Nonaktif'])->default('Nonaktif');
        $table->timestamps();

        $table->foreign('tahun_akademik_id')
            ->references('id')->on('tahun_akademik')
            ->onDelete('cascade');
    });
}
};
