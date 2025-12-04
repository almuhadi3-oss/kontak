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
    Schema::table('pengaduan', function (Blueprint $table) {
        $table->enum('verifikasi', ['belum_diperiksa', 'lengkap', 'tidak_lengkap'])->default('belum_diperiksa');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            //
        });
    }
};
