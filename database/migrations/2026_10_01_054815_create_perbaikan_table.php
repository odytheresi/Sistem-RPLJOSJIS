<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perbaikan', function (Blueprint $table) {
            $table->increments('id_perbaikan');

            $table->unsignedInteger('id_charger');
            $table->unsignedInteger('id_keluhan')->nullable();

            $table->dateTime('tgl_jadwal');

            $table->string('jenis_maintenance', 100);

            $table->text('keterangan')->nullable();

            $table->enum('status', [
                'dijadwalkan',
                'proses',
                'selesai',
                'dibatalkan'
            ])->default('dijadwalkan');

            $table->dateTime('tgl_selesai')->nullable();

            $table->timestamps();

            $table->foreign('id_charger')
                ->references('id_charger')
                ->on('charger')
                ->cascadeOnDelete();

            $table->foreign('id_keluhan')
                ->references('id_keluhan')
                ->on('keluhan')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbaikan');
    }
};