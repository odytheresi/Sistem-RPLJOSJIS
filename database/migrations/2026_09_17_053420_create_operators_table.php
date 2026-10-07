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
        Schema::create('operator', function (Blueprint $table) {
            $table->increments('id_operator');
            $table->integer('id_role');
            $table->string('nama_operator', 100);
            $table->string('email', 100)->unique();
            $table->string('no_hp', 20)->nullable();
            $table->string('password', 255);
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
        Schema::dropIfExists('operators');
    }
};
