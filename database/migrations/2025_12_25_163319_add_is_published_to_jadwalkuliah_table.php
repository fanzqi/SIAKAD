<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('jadwal', 'is_published')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->tinyInteger('is_published')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwalkuliah', function (Blueprint $table) {
            //
        });
    }
};