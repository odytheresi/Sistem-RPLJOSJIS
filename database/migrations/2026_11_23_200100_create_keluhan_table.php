<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluhan', function (Blueprint $table) {
            $table->id('id_keluhan');
            $table->unsignedBigInteger('id_pengemudi');
            $table->unsignedBigInteger('id_station');
            $table->unsignedBigInteger('id_sesi')->nullable();
            $table->text('isi_keluhan');
            $table->string('status', 20)->default('baru');
            $table->timestamps();

            $table->foreign('id_pengemudi')->references('id_pengemudi')->on('pengemudi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluhan');
    }
};