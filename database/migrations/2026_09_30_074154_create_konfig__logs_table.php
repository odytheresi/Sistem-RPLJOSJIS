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
         Schema::create('konfig_sistem', function (Blueprint $t) {
            $t->id('id_konfig');
            $t->string('nm_konfig', 100)->unique();
            $t->text('nilai')->nullable();
            $t->text('deskripsi')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfig__log');
    }
};
