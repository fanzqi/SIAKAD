<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'role')) {
            $table->enum('role', [
                'akademik',
                'warek1',
                'dekan',
                'kaprodi',
                'dosen',
                'mahasiswa'
            ])->default('mahasiswa')->after('password');
        }
    });
}

public function down()
{
    Schema::create('notification_user', function (Blueprint $table) {
    $table->id();
    $table->foreignId('notification_id')->constrained('notifications')->onDelete('cascade');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->boolean('is_read')->default(0);
    $table->timestamps();
});


}
};
