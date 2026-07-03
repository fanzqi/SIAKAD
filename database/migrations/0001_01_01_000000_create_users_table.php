<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('username')->unique();
    $table->string('password');

    $table->enum('role', [
        'akademik',
        'warek1',
        'dekan',
        'kaprodi',
        'dosen',
        'mahasiswa'
    ])->default('mahasiswa');

    $table->rememberToken();
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
