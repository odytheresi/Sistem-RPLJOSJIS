<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operator', function (Blueprint $table) {
            $table->increments('id_operator');

            $table->unsignedBigInteger('id_user');

            $table->string('nama_operator', 100);
            $table->string('no_hp', 20)->nullable();

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operator');
    }
};