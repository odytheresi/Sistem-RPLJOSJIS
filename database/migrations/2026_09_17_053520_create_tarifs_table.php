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
        Schema::create('tarif', function (Blueprint $table) {
            $table->increments('id_tarif');
            $table->unsignedInteger('id_station');
            $table->decimal('harga_per_kwh', 12, 2)->default(2500.00);
            $table->dateTime('berlaku_mulai');
            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->foreign('id_station')
                  ->references('id_station')
                  ->on('charging_station');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif');
    }
};
