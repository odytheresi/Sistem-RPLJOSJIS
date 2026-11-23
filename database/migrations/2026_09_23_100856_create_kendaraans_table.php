<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id('id_kendaraan');
            $table->unsignedBigInteger('id_pengemudi');
            $table->string('no_plat', 15);
            $table->string('merk', 50);
            $table->string('model', 50);
            $table->year('tahun');
            $table->decimal('kapasitas_baterai', 8, 2); // kWh

            $table->foreign('id_pengemudi')
                ->references('id_pengemudi')->on('pengemudi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};