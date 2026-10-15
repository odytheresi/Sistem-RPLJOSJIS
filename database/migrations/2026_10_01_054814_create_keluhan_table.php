<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluhan', function (Blueprint $table) {
            $table->increments('id_keluhan');

            // Akan terhubung dengan tabel Pengemudi
            // ketika project kelompok digabung.
            $table->unsignedInteger('id_pengemudi')->nullable();

            $table->unsignedInteger('id_station');

            // Akan terhubung dengan sesi charging
            // ketika modul Pengemudi digabung.
            $table->unsignedInteger('id_sesi')->nullable();

            $table->text('isi_keluhan');

            $table->enum('status', [
                'menunggu',
                'diproses',
                'selesai',
                'ditolak'
            ])->default('menunggu');

            $table->timestamps();

            $table->foreign('id_station')
                ->references('id_station')
                ->on('charging_station')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluhan');
    }
};