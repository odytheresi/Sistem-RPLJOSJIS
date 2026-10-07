<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sesi_charger', function (Blueprint $table) {
           $table->increments('id_sesi');

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('id_charger');
            $table->unsignedInteger('id_kendaraan');
            $table->unsignedInteger('id_tarif');

            $table->dateTime('wkt_mulai');
            $table->dateTime('wkt_selesai')->nullable();
            $table->decimal('energi_pakai', 10, 2)->default(0.00);
            $table->integer('durasi')->default(0);
            $table->decimal('total_bayar', 12, 2)->default(0.00);

            $table->enum('status', [
                'menunggu',
                'berlangsung',
                'selesai',
                'dibatalkan'
            ])->default('menunggu');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('pengemudi');

            $table->foreign('id_charger')
                ->references('id_charger')
                ->on('charger');

            $table->foreign('id_kendaraan')
                ->references('id_kendaraan')
                ->on('kendaraan');

            $table->foreign('id_tarif')
                ->references('id_tarif')
                ->on('tarif');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_charger');
    }
};
