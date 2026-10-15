<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charger', function (Blueprint $table) {
            $table->increments('id_charger');

            $table->unsignedInteger('id_station');
            $table->unsignedInteger('id_konektor');

            $table->string('kode_charger', 50)->unique();
            $table->decimal('daya_maks', 10, 2);

            $table->enum('status', [
                'tersedia',
                'digunakan',
                'maintenance',
                'error'
            ])->default('tersedia');

            $table->timestamps();

            $table->foreign('id_station')
                ->references('id_station')
                ->on('charging_station')
                ->cascadeOnDelete();

            $table->foreign('id_konektor')
                ->references('id_konektor')
                ->on('tipe_konektor')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charger');
    }
};