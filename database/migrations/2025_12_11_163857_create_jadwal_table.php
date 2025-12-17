<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('jadwal', function (Blueprint $table) {
        $table->unsignedBigInteger('fakultas_id')->nullable()->after('semester');
        $table->unsignedBigInteger('prodi_id')->nullable()->after('fakultas_id');

        $table->foreign('fakultas_id')->references('id')->on('fakultas')->onDelete('set null');
        $table->foreign('prodi_id')->references('id')->on('program_studi')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('jadwal', function (Blueprint $table) {
        $table->dropForeign(['fakultas_id']);
        $table->dropForeign(['prodi_id']);
        $table->dropColumn(['fakultas_id', 'prodi_id']);
    });
}

};