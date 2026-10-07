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
        Schema::create('charging_station', function (Blueprint $table) {
            $table->increments('id_station');
            $table->unsignedInteger('id_operator');
            $table->string('nama_st', 100);
            $table->text('alamat');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status', [
                'aktif',
                'nonaktif',
                'maintenance'
            ])->default('aktif');

            $table->foreign('id_operator')
                  ->references('id_operator')
                  ->on('operator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charging_station');
    }
};
