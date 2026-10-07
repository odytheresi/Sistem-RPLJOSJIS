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
            $table->id('id_pengemudi');
            $table->foreignId('id_user')->unique()->constrained('user', 'id_user');
            $table->string('nm_pengemudi', 100)->nullable();
            $table->string('email')->unique();
            $table->string('no_hp', 20)->unique();
            $table->timestamps();
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
