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
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->increments('id_kendaraan')->primary();
            $table->unsignedInteger('user_id');
            $table->string('no_plat', 15)->unique();
            $table->string('merk', 50);
            $table->string('model', 50);
            $table->decimal('kapasitas_baterai', 8, 2);

            $table->foreign('user_id')
                ->references('user_id')
                ->on('pengemudi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
