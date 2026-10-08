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
            $table->id('id_charger'); // Primary Key sesuai ERD
            $table->unsignedBigInteger('id_station'); // Foreign Key ke charging_station
            $table->unsignedBigInteger('id_konektor'); // Foreign Key ke tipe_konektor
            $table->string('kd_charger');
            $table->integer('daya_maks');
            $table->enum('status', ['tersedia', 'digunakan', 'error', 'perbaikan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chargers');
    }
};
