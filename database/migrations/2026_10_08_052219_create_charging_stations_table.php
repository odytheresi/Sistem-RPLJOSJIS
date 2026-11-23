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
            $table->id('id_station'); // Primary Key sesuai ERD
            $table->unsignedBigInteger('id_operator'); // Foreign Key operator
            $table->string('nama_st');
            $table->text('alamat');
            $table->decimal('longitude', 11, 8);
            $table->decimal('latitude', 10, 8);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charging_stations');
    }
};
