<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengemudi', function (Blueprint $table) {
           $table->id('id_pengemudi');
            $table->unsignedBigInteger('user_id');
            $table->string('no_sim', 30);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')->on('login');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengemudi');
    }
};