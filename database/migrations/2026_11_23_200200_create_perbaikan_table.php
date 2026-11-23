<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perbaikan', function (Blueprint $table) {
            $table->id('id_perbaikan');
            $table->unsignedBigInteger('id_charger');
            $table->unsignedBigInteger('id_keluhan')->nullable();
            $table->dateTime('tgl_jadwal')->nullable();
            $table->string('jenis_maintenance', 50)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status', 20)->default('dijadwalkan');
            $table->dateTime('tgl_selesai')->nullable();
            $table->timestamps();

            $table->foreign('id_charger')->references('id_charger')->on('charger');
            $table->foreign('id_keluhan')->references('id_keluhan')->on('keluhan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbaikan');
    }
};