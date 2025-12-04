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
        $table->string('surat_pengantar')->nullable();
        $table->string('kk')->nullable();
        $table->string('ktp')->nullable();
        $table->string('bpjs')->nullable();
        $table->string('foto')->nullable();
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
