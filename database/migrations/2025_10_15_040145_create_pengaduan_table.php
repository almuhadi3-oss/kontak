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
    Schema::create('pengaduan', function (Blueprint $table) {
        $table->id();
        $table->string('kode_laporan')->unique();
        $table->unsignedBigInteger('id_layanan')->nullable(); // id layanan
        $table->string('nama');
        $table->string('nik')->nullable();
        $table->string('alamat')->nullable();
        $table->text('laporan');
        $table->enum('status', ['baru', 'diproses', 'diterima', 'ditolak', 'menunggu', 'selesai'])->default('baru');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
