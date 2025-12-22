<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            // kolom
            $table->unsignedBigInteger('fakultas_id')->nullable()->after('semester');
            $table->unsignedBigInteger('program_studi_id')->nullable()->after('fakultas_id');

            // foreign key
            $table->foreign('fakultas_id')
                  ->references('id')
                  ->on('fakultas')
                  ->onDelete('set null');

            $table->foreign('program_studi_id')
                  ->references('id')
                  ->on('program_studi')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            $table->dropForeign(['fakultas_id']);
            $table->dropForeign(['program_studi_id']);

            $table->dropColumn(['fakultas_id', 'program_studi_id']);
        });
    }
};
