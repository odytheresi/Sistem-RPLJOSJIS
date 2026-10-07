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
        Schema::create('tipe_konektor', function (Blueprint $table) {
            $table->increments('id_konektor');
            $table->string('nm_konektor', 155)->unique();
            $table->enum('jenis_charging', [
                'AC Type 2',
                'DC Fast Charging'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_konektor');
    }
};
