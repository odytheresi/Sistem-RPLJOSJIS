<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarif', function (Blueprint $table) {
            $table->increments('id_tarif');

            $table->unsignedInteger('id_station');
            $table->unsignedInteger('id_charger')->nullable();

            $table->decimal('harga_per_kwh', 12, 2);

            $table->dateTime('berlaku_mulai');
            $table->dateTime('berlaku_selesai')->nullable();

            $table->timestamps();

            $table->foreign('id_station')
                ->references('id_station')
                ->on('charging_station')
                ->cascadeOnDelete();

            $table->foreign('id_charger')
                ->references('id_charger')
                ->on('charger')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarif');
    }
};