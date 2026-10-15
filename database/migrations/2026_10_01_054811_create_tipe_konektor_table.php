<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipe_konektor', function (Blueprint $table) {
            $table->increments('id_konektor');

            $table->string('nama_konektor', 50);
            $table->string('jenis_charging', 50)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipe_konektor');
    }
};