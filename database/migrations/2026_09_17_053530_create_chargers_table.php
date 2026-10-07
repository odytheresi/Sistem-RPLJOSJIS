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
        Schema::create('charger', function (Blueprint $table) {
             $table->increments('id_charger');
            $table->unsignedInteger('id_station');
            $table->unsignedInteger('id_konektor');
            $table->string('kd_charger', 100);
            $table->decimal('daya_maks', 8, 2);
            $table->enum('status', [
                'aktif',
                'nonaktif',
                'maintenance'
            ])->default('aktif');

            $table->foreign('id_station')
                  ->references('id_station')
                  ->on('charging_station');

            $table->foreign('id_konektor')
                  ->references('id_konektor')
                  ->on('tipe_konektor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charger');
    }
};
