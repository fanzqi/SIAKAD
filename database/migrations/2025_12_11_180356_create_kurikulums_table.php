<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurikulumsTable extends Migration
{
    public function up()
    {
       Schema::create('kurikulums', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tahun_akademik_id')->constrained()->onDelete('cascade');
    $table->string('kode_mk');
    $table->string('nama_mk');
    $table->integer('sks');
    $table->enum('wajib_pilihan', ['Wajib','Pilihan']);
    $table->string('prasyarat')->nullable();
    $table->enum('status', ['Aktif','Nonaktif']);
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('kurikulums');
    }
}
