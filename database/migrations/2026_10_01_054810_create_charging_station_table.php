<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charging_station', function (Blueprint $table) {
            $table->increments('id_station');

            $table->unsignedInteger('id_operator');

            $table->string('nama_station', 100);
            $table->text('alamat');

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->enum('status', [
                'aktif',
                'nonaktif',
                'maintenance'
            ])->default('aktif');

            $table->timestamps();

            $table->foreign('id_operator')
                ->references('id_operator')
                ->on('operator')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charging_station');
    }
};