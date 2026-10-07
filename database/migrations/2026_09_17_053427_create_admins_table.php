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
        Schema::create('admin', function (Blueprint $table) {
            $table->integer('id_admin')->primary();
            $table->integer('id_role');
            $table->string('nma_admin', 100);
            $table->string('email', 100)->unique();
            $table->string('pass', 255);

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
        Schema::dropIfExists('admins');
    }
};
