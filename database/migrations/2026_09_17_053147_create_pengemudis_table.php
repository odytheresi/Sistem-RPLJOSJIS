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
        Schema::create('pengemudi', function (Blueprint $table) {
            $table->increments('user_id');
            $table->integer('id_role');
            $table->string('nma_user', 100);
            $table->string('no_hp', 20);
            $table->string('email', 100)->unique();
            $table->string('pass', 255);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->foreign('id_role')
                ->references('id_role')
                ->on('role');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengemudi');
    }
};
