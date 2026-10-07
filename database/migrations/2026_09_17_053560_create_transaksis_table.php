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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id_transaksi');

            $table->unsignedInteger('id_sesi')->unique();
            $table->string('mtd_bayar', 50);
            $table->decimal('jumlah', 12, 2);

            $table->enum('status_byr', [
                'menunggu',
                'berhasil',
                'gagal',
                'dibatalkan'
            ])->default('menunggu');

            $table->dateTime('wkt_byr');

            $table->foreign('id_sesi')
                ->references('id_sesi')
                ->on('sesi_charger');
                });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
