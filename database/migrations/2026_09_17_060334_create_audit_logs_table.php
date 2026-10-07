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
        Schema::create('audit_log', function (Blueprint $table) {
            $table->increments('id_audit')->primary();
            $table->integer('id_admin');
            $table->string('aktivitas', 100);
            $table->dateTime('waktu')->useCurrent();
            $table->text('keterangan')->nullable();

            $table->foreign('id_admin')
                  ->references('id_admin')
                  ->on('admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
