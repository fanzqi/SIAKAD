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
            $table->string('tahun_akademik');
            $table->enum('semester', ['Ganjil', 'Genap', 'Pendek']);
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Nonaktif');
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